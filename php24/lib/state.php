<?php
class state
{   
    private static function f($name)
    {
        return  in_array($name, req::$wait);
    }


    

    # авторы
    #
    static function userList()
    {
        if ( ! self::f(__FUNCTION__) )      return;

        res::$ret['userList']  =   author::dbInit();
    }

    



    # пачка
    #
    static function packStart()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        
        res::$ret[__FUNCTION__]    =   pack::$start;
    }

    static function isProject()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('view') )         return;
        

        res::$ret[__FUNCTION__]    =   isset(pack::$tree[ pack::$start ]);
        res::$ret[__FUNCTION__]    =   pack::$project ?  res::$ret[__FUNCTION__]:  null ;
    }
    
    static function packBc()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;

        $bc     =   array_reverse(pack::$bc);

        foreach($bc as $k => &$v)
        {
            $v   =   array(
                'id'    =>  pack::$list[ $v ]['id'],
                'name'  =>  pack::$list[ $v ]['name'],
                '_cur'  =>  pack::$start == $v ?  'current' : '',
                '_pub'  =>  pack::$list[ $v ]['public'] ?? 0 ?  'public' : '',
            );
        }

        res::$ret[__FUNCTION__]  =  $bc;
    }
    


    static function packTree()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('view') )         return;
        

        $project    =  tree::project();
        $tree       =   array();
        
        foreach( pack::$tree[ $project ] ?? []  as  $pack )
        {
            $tree[] =   array(
                'id'    =>  $pack['id'] ?? '',
                'space' =>  $pack['space'],
                'name'  =>  $pack['name'],
                '_prj'  =>  isset(pack::$tree[ $pack['id'] ]) ?  'prj' :  '',
                '_act'  =>  $pack['id'] == pack::$start ?  'active' :  '',
            );
        }


        res::$ret[__FUNCTION__]  =  $tree;
    }
    


    static function packTitle()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;


        $title  =   pack::$list[ pack::$start ]['name'];
        

        if ( !isset(pack::$tree[ pack::$project ]) && pack::$project > 0 )
        {
            $title = pack::$list[ pack::$project ]['name']. ' / '. $title;
        }
        
        res::$ret[__FUNCTION__]    =   $title;
    }
    
    
    
    
    static function packMenu()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( empty(pack::$access) )         return; # нет прав
        if ( count(pack::$access) == 1 )    return; # только обзор
        
        
        # поименовать пункты меню
        #
        $menu   =   pack::$access;
        #
        foreach($menu as &$v)
        {
            $v  =   array(
                $v          =>  $v,
                'view'      =>  'Обзор',
                'line'      =>  'Редактор',
                'tree'      =>  'Проект',
                'access'    =>  'Доступ',
                'log'       =>  'История',
            )[ $v ];
        }
        #
        $menu['name']   =   $menu[ url::$level[1] ?? '' ]  ??  'Обзор';
        #
        # выход
        if ( pack::$project == 0 )      $menu['bye'] =   'Выйти';
        
        
        res::$ret[__FUNCTION__]  =   $menu;
    }
    




    static function lineHtml()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('view') )         return;
        

        line::dbInit();
        
        res::$ret[__FUNCTION__]  =   line::html();
        
    }
    


    static function lineText()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('line') )         return;
        

        line::dbInit();
        
        res::$ret[__FUNCTION__]    =   line::text();
    }




    static function treeText()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('view') )         return;



        $project    =  tree::project();
        $text   =   '';

        foreach( pack::$tree[ $project ] ?? [] as $pack )
        {
            $space  =   str_repeat(" ", $pack['space']);
            $id     =   empty($pack['name']) ?  '' :  '    '.  $pack['id'];
            $text  .=   "\n".  $space.  $pack['name'].  $id;
        }
        
        res::$ret[__FUNCTION__]  =   substr($text, 1);
    }



    
    
    static function accessText()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('access') )       return;

        access::dbInit();
        

        res::$ret[__FUNCTION__]  =   access::asText();
    }



    static function logList()
    {
        if ( ! self::f(__FUNCTION__) )      return;
        if ( empty(pack::$start) )          return;
        if ( pack::denied('log') )          return;
        

        # получить записи лога
        #
        $list   =   log::dbList();
        #
        # вернуть данные для фронта с урезанными полями
        #
        foreach( $list as  &$v)
        {
            $v['up_name']       =   "Поднять";
            $v['target_name']   =   strtr($v['target'], [
                'tree'  =>  'Дерево',
                'file'  =>  'Файл',
                'log'   =>  'Из лога #' .$v['row'] ,
                'access'=>  'Права'
            ]);
            
            unset($v['user']);
            unset($v['json']);
        }
        

        res::$ret[__FUNCTION__]  =   $list;
    }



}