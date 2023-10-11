<?php
class state
{   

    
    static function userList()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


        res::$ret['userList']  =   user::list();
    }

    



    # пачка
    #
    static function packStart()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        
        res::$ret[__FUNCTION__]    =   pack::$start;
    }

    static function packProject()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        
        res::$ret[__FUNCTION__]    =   pack::$project;
    }
    
    static function packBc()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        $bc     =   array_reverse(pack::$bc);

        foreach($bc as $k => &$v)
        {
            $v   =   array(
                'id'    =>  pack::$list[ $v ]['id'],
                'name'  =>  pack::$list[ $v ]['name'],
                '_act'  =>  '', //!isset($bc[$k+1]) ?  'active' : '',
                '_cur'  =>  pack::$start == $v ?  'current' : '',
            );
        }

        res::$ret[__FUNCTION__]  =  $bc;
    }
    


    static function packTree()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;


        $project    =  pack::$start;
        $project    =  !isset( pack::$tree[ $project ] ) ?  pack::$project :  $project;
        $tree       =   array();
        
        foreach( pack::$tree[ $project ] ?? []  as  $pack )
        {
            $tree[] =   array(
                'id'    =>  $pack['id'] ?? '',
                'space' =>  $pack['space'],
                'name'  =>  $pack['name'],
                '_prj'  =>  isset(pack::$tree[ $pack['id'] ]) ?  'self' :  '',
                '_act'  =>  $pack['id'] == pack::$start ?  'active' :  '',
            );
        }


        res::$ret[__FUNCTION__]  =  $tree;
    }
    


    static function packTitle()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;


        $title  =   pack::$list[ pack::$start ]['name'];
        
        // ui::vd(pack::$tree);
        // ui::vd(pack::$project);

        if ( !isset(pack::$tree[ pack::$project ]) && pack::$project > 0 )
        {
            $title = pack::$list[ pack::$project ]['name']. ' / '. $title;
        }
        
        res::$ret[__FUNCTION__]    =   $title;
    }
    
    
    
    
    static function packMenu()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        // if ( empty(pack::$start) )                      return;


        # проверить права
        #



        # добавить меню пачки
        #
        $menu['line']   =   'Записи';
        $menu['tree']   =   'Дерево';
        $menu['access'] =   'Доступ';
        #
        if ( !isset(pack::$tree[ pack::$start ])  && pack::$project ) 
        {
            $menu['treeAdd'] =   '+ Проект';
        }
        #
        if ( isset(pack::$tree[ pack::$start ])  && pack::$project )
        {
            $menu['treeDel'] =   '- Проект';
        }
        #
        $menu['log'] =   'Логи';



        res::$ret[__FUNCTION__]  =   $menu;
    }
    




    static function lineHtml()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        line::dbInit();
        line::html();
        
        res::$ret[__FUNCTION__]  =   line::$html;
    }
    


    static function lineText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        line::dbInit();
        
        res::$ret[__FUNCTION__]    =   line::text();
    }




    static function treeText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        $project    =  pack::$start;
        $project    =  !isset( pack::$tree[ $project ] ) ?  pack::$project :  $project;
        $text   =   '';

        foreach( pack::$tree[ $project ] as $pack )
        {
            $space  =   str_repeat(" ", $pack['space']);
            $id     =   empty($pack['name']) ?  '' :  '    '.  $pack['id'];
            $text  .=   "\n".  $space.  $pack['name'].  $id;
        }
        
        res::$ret[__FUNCTION__]  =   substr($text, 1);
    }




    static function accessHtml()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;


    }
    
    
    static function accessText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        
    }



    static function logList()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        
        log::dbList();

        ui::vd(log::$list);

        res::$ret[__FUNCTION__]  =   log::$list;
    }



}