<?php
class kfilter
{
    public $field;
    public $param;
    
    
    public $where;
    public $order;
    public $page;
    public $limit;
    
    
    public $all;
    public $pages;
    
    
    
    ###########################################################################
    # УСТАНОВКИ ПОЛЕЙ ФИЛЬТРА
    #
    public function __construct($fields=null, $params=null)
    {
        $this->field    =   $fields;
        $this->param    =   $params;
        
        if ( empty($fields) )   return ;
        
        
        $this->setFields($fields);
    }
    #
    #
    #
    public function setFields($fields)
    {
        $this->field  =  $fields;
        
        $this->parse();
    }
    #
    #
    ###########################################################################
    
    
    
    
    
    
    
    
    ###########################################################################
    # ПАРСИНГ
    # распарсить строку гет-параметры
    #
    private function parse()
    {
        $param          =   $this->param ?? $_GET;
        
        $this->where    =   $this->parseWhere( $param['where'] ?? '' );
        
        $this->order    =   $this->parseOrder( $param['order'] ?? '' );
        
        $page           =   !empty($param['page'])?    (int)$param['page']:   0;
        $this->page     =   abs($page);
        
        $limit          =   !empty($param['limit'])?   (int)$param['limit']:  50;
        $this->limit    =   abs($limit);
    }
    #
    #
    # распарсить значения для условия
    #
    private function parseWhere($string)
    {
        if ( empty(trim($string)) )     return array();
        
        
        // load::vd($string);
        
        # экранирование
        $escape0    =   array('\;'=>"\rE1\r", '\,'=>"\rE2\r", '\('=>"\rE3\r",  '\)'=>"\rE4\r",);
        $escape1    =   array(      "\rE1\r"=>';',  "\rE2\r"=>',',  "\rE3\r"=>'(',   "\rE4\r"=>')', );
        $string     =   strtr($string, $escape0);
        
        
        # разобрать группы
        #
        for ($gn=0, $m=[];  preg_match_all("#\( [^()]+ \)#x", $string, $m); )
        {
            foreach ($m[0] as $v)
            {
                $group[ $gn ] =  $v;
                
                $pos    =   strpos($string, $v);
                $len    =   strlen($v);
                $string =   substr_replace($string, "\r".$gn."\r;", $pos, $len );
            }
            
            $gn++;
        }
        #
        $group[$gn] = $string;
        
        

        # распарсить объекты
        #
        foreach ($group as &$objects)
        {
            # найти объекты
            #
            $objects   =   trim($objects, '();');
            $objects   =   explode(';', $objects);
            
            
            # распарсить объекты
            #
            foreach ($objects as &$obj)
            {
                # вставить группу
                if ( substr($obj, 0, 1) == "\r" )
                {
                    $gkey   =   (int)trim($obj);
                    $obj    =   $group[ $gkey ];
                    continue;
                }
                
                
                # объект
                $e      =   explode(',', $obj);
                $obj    =   array(
                    'field'     =>  $e[0] ?? null,
                    'oper'      =>  $e[1] ?? null,
                    'value'     =>  array_slice($e, 2),
                );
                
                # разэкранировать значения
                foreach ($obj['value'] as &$v3)   $v3 = strtr($v3, $escape1);
            }
        }
        
        
        
        return  $group[$gn];
    }
    #
    #
    # распарсить значения для сортировки
    #
    private function parseOrder($string)
    {
        if ( empty(trim($string)) )     return array();
        
        
        $order      =   array();
        $explode    =   explode(';', trim($string));
        
        foreach ($explode as $v)
        {
            $e      =   explode(',', $v);
            $e[1]   =   $e[1] ?? 'ASC';
            
            if ( !in_array($e[1], ['ASC', 'DESC']) )    continue;
            
            
            $order[ $e[0] ]   =   $e[1];
        }
        
        
        return $order;
    }
    #
    #
    ###########################################################################
    
    
    
    
    
    
    
    
    
    
    ###########################################################################
    # УМОЛЧАНИЯ
    # значения по-умолчанию для where
    #
    public function defaultWhere($string)
    {
        
    }
    #
    #
    #
    # значения по-умолчанию для order by
    #
    public function defaultOrder($string)
    {
        $parse  =   $this->parseOrder($string);
        
        foreach ($parse as $field => $sort)
        {
            if ( !isset($this->field[ $field ]) )   continue;
            if ( isset($this->order[ $field ])  )   continue;
            
            $this->order[ $field ] = $sort;
        }
        
        
        //load::vd($parse);
    }
    #
    #
    ###########################################################################
    
    
    
    
    
    
    
    
    ###########################################################################
    # SQL
    # for WHERE
    #
    public function sqlWhere($indent=16)
    {
        # отступ для форматирования sql
        #
        $indent =   is_int($indent)? str_repeat(' ', $indent):  $indent;
        $sql    =   '';
        $oper   =   array('ILIKE', 'LIKE', 'IN', '=', '>', '<', '>=', '<=', '!=', '<>', 'BETWEEN', 'IS');
        
        
        
        foreach ($this->where as $v)
        {
            
            if ( !isset($v['field']) )                  continue;
            if ( !isset($this->field[ $v['field'] ]) )  continue;
            if ( !in_array($v['oper'], $oper) )         continue;
            
            
            if ( $v['oper'] == 'IN' )
            {
                foreach ($v['value'] as &$value)    $value = db::v($value);
                
                $v['value'] =   "(" .implode(', ', $v['value']). ")";
            }
            elseif ( $v['oper'] == 'BETWEEN'  && isset($v['value'][0])  && isset($v['value'][1]) )
            {
                $v['value'] =   db::v($v['value'][0]). ' AND ' .db::v($v['value'][1]);
            }
            else {
                $v['value'] =   db::v(implode('', $v['value']), 'str');
            }
            
            
            $sql    .=  $sql?  $indent. 'AND ':  $indent; 
            $sql    .=  $this->field[ $v['field'] ]['where']. ' ' .$v['oper']. ' ' .$v['value']. "\n"; 
            
        }
        
        
        // ob_clean();
        // load::vd($this->where);
        // load::vd($sql);
        // die;
        
        
        # вернуть секцию sql
        #
        if ( empty($sql) )  return '';
        #
        #
        $sql    =   "WHERE". "\n" .$sql;
        
        return $sql;
    }
    #
    #
    #
    # for ORDER BY
    #
    public function sqlOrderBy($indent=16)
    {
        
        foreach ($this->order as $alias => $sort)
        {
            if ( !isset($this->field[ $alias ]) )           continue;
            if ( !isset($this->field[ $alias ]['order']) )  continue;
            
            
            $order[]  =  $this->field[ $alias ]['order']. ' ' .$sort;
        }
        
        if ( !isset($order) )   return '';
        
        
        # отступ для форматирования sql
        # 
        $indent =   is_int($indent)? str_repeat(' ', $indent):  $indent;
        #
        $sql    =
        "ORDER BY". "\n"
        .$indent. implode( "\n".$indent.',' , $order);
        
            
        return $sql;
    }
    #
    #
    #
    # for LIMIT
    #
    public function sqlLimit()
    {
        $sql    =   $this->limit. ' OFFSET ' .$this->page*$this->limit;
        
        return  $sql;
    }
    #
    #
    ###########################################################################
    
    
    
    
    
    
    
    
    
    ###########################################################################
    # ПОМОГАЛКИ ОТОБРАЖЕНИЮ
    #
    # количество страниц
    #
    public function calcPages($count)
    {
        $this->all = $count;
        
        return ceil($count / $this->limit);
    }
    #
    # используется ли фильтр
    #
    public function isUsed()
    {
        if ( !empty($this->where) )     return 'used';
        if ( !empty($this->order) )     return 'used';
        
        return '';
    }
    #
    # вывод в поле формы
    #
    public function valueWhere($field)
    {
        foreach ($this->where as $v)
        {
            if ( $v['field'] == $field )
            {
                $oper   =   !in_array($v['oper'], ['=', 'IN'])?  $v['oper'].',':  ''; 
                
                return  $oper. db::v2input( implode(',', $v['value']) );
            }
        }
        
        return '';
    }
    #
    #
    #
    public function printForm1()
    {
        ob_start();
        
        $field  =   $this->field ?? array();
        
        ?>
        
        <form id="filter" class="kfilter1 9active" onsubmit="return kfilter1.form(this)">
        	
        	<div class="flex flex1">
            	<div class="where">
            		<div class="head">Условия</div>
                	<?
                	foreach ($this->field as $k => $v)
                	{
                	    if ( !isset($v['where']) ) continue;
                	    
                	    ?>
                	    <div class="field">
                	    	<div class="name"><?= $v['name'] ?></div>
                	    	<input class="kWhere value" data-field="<?= $k ?>" value="<?= $this->valueWhere($k) ?>" />
                	    </div>
                	    <?
                	}
                	?>
            	</div>
            	
            	<div class="order">
            		<div class="head">Сортировка</div>
            		<?
                	foreach ($this->field as $k => $v)
                	{
                	    if ( !isset($v['order']) ) continue;
                	    
                	    ?>
                	    <div class="field">
                	    	<div class="name"><?= $v['name'] ?></div>
                	    	<div class="sort">
                	    		<select class="kOrder" data-field="<?= $k ?>">
                	    		<?
                	    		foreach ([''=>'', 'ASC'=>'123', 'DESC'=>'321'] as $k2=>$v2) echo '<option value="' .$k2. '" ' .($this->order[ $k ] == $k2 ? 'selected="1"': ''). '>' .$v2. '</option>';
                	    		?>
                	    		</select>
            				</div>
                	    </div>
                	    <?
                	}
                	?>
            	</div>
            	
            	<div class="limit">
            		<div class="head">Всего: <?= $this->all ?? '' ?></div>
            		<div class="field" data-field="limit">
            	    	<div class="name">Выводить</div>
            	    	<input class="value limit" type="text" value="<?= $this->limit ?>" id="kLimit" />
            	    </div>
            	    <div class="field" data-field="page">
            	    	<div class="name">Страница</div>
            	    	<input class="value limit" type="text" value="<?= $this->page+1 ?>" id="kPage" />
            	    </div>
            	    <div class="field">
            	    	<div class="name name1"><a href="<?= url::$dir[0] ?>">Сбросить фильтр</a></div>
            	    </div>
            	</div>
        	</div>
        	
        	
        	<div class="submit">
    			<button class="btn link">Применить</button>
        	</div>
        	
        </form>
        
        <?
        $html   =   ob_get_clean();
        
        return $html;
    }
    
    #
    #
    ###########################################################################
    
    
    
    
}