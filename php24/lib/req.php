<?php
class req
{
    static $param   =   array();
    static $wait    =   array();

    
    # запросы через url
    #
    static function fromUrl()
    {
        if ( $_POST )               return;

        # тип ответа
        #
        res::$render    =   'html';



        # запрос главной страницы
        #
        if ( url::$path == '/' )
        {
            req::$wait  =  array('userList');
        }
        


        # запрос страницы пачки
        #
        elseif ( isset(url::$level[0])  && is_numeric(url::$level[0])  && url::$level[0] > 1 )
        {
            req::$param['pack'] =   url::$level[0];
            req::$wait          =   self::packSokr(['pack*']);
            
            
            if      ( !isset(url::$level[1]) )      req::$wait[]  =   'lineHtml';
            elseif  ( url::$level[1] == 'line' )    req::$wait[]  =   'lineText';
            elseif  ( url::$level[1] == 'tree' )    req::$wait[]  =   'treeText';
            elseif  ( url::$level[1] == 'access' )  req::$wait    =   array_merge(req::$wait, ['accessArray', 'accessText']);
            else    req::$wait[]  =   '404';      
        }
        
    }





    
    # развернуть сокращение для перменной pack*
    #
    private static function packSokr($list)
    {
        if ( ! in_array('pack*', $list) )   return $list;

        unset($list[ array_search('pack*', $list) ]);
        
        $list = array_merge($list, [
            'packStart',
            'packBc',
            'packTree',
            'packHeap',
            'packMenu',
            'packTitle',
            'packProject',
        ]);

        return $list;
    }




    # запросы к api
    #
    static function fromApi()
    {
        if ( empty($_POST['rtoken']) )      return;
        if ( !isset(url::$level[0]) )       return;
        if ( url::$level[0] != 'api' )      return;

        # тип ответа
        #
        res::$render    =   "json";


        # ожидания
        #
        if ( !empty($_POST['wait']) && is_array($_POST['wait']) )
        {
            req::$wait  =   self::packSokr($_POST['wait']);
            unset($_POST['wait']);
        }



        # операции
        #
        req::$param = $_POST;
        
    }        


    # группа переменных
    #
    private static function packCheckWait($wait)
    {
        $add    =   array();
        $vars   =   array(
            'packStart',
            'packBc',
            'packTree',
            'packHeap',
            'packMenu',
            'packTitle',
            'packProject',
        );
        
        foreach( $vars as $v )
        {
            if ( ! in_array($v, $wait) )        continue;
            if ( in_array($v, req::$wait) )     continue;

            $add[] = $v;
        }
        

        return  array_merge(req::$wait, $add);
    }

    

}