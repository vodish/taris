<?php
class state
{   

    
    static function userList()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;


        res::$ret['userList']  =   author::dbInit();
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
                '_pub'  =>  pack::$list[ $v ]['public'] ?? 0 ?  'public' : '',
            );
        }

        res::$ret[__FUNCTION__]  =  $bc;
    }
    


    static function packTree()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;


        $project    =  tree::project();
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
        if ( empty(pack::$start) )                      return;


        # пункты меню
        #
        $v      =   array(
            'view'      =>  'Обзор',
            'line'      =>  'Редактор',
            'tree'      =>  'Проект',
            'access'    =>  'Доступ',
            'treeAdd'   =>  'Обзор',
            'treeDel'   =>  'Обзор',
            'log'       =>  'История',
        );
        #
        #
        # добавить меню пачки
        #
        $menu['name']   =   strtr(url::$level[1] ?? 'view', $v);
        $menu['view']   =   'Обзор';
        $menu['line']   =   'Редактор';
        $menu['tree']   =   'Проект';
        $menu['access'] =   'Доступ';
        $menu['log']    =   'История';
        # проект
        if ( $menu['name']=='Обзор'  && !isset(pack::$tree[ pack::$start ])  && pack::$project )    $menu['treeAdd'] =   '+';
        if ( $menu['name']=='Обзор'  && isset(pack::$tree[ pack::$start ])  && pack::$project )     $menu['treeDel'] =   '-';
        # выход
        if ( pack::$project == 0 )  $menu['bye'] =   'Выйти';


        

        # проверить права
        # удалить лишние пункты
        #
        if      ( author::$role == null )       $menu  =   array();
        elseif  ( author::$role == 'view' )     $menu  =   array_filter($menu, function($v, $k) { return in_array($k, ['name', 'view']); }, ARRAY_FILTER_USE_BOTH);
        elseif  ( author::$role == 'edit' )     $menu  =   array_filter($menu, function($v, $k) { return in_array($k, ['name', 'view', 'line']); }, ARRAY_FILTER_USE_BOTH);
        #
        #
        # не актуальная выпадайка для одного пункта меню
        #
        if      ( count($menu) == 2 )           $menu   =   array('name' =>$menu['name']);


        // ui::vd($menu);
        // ui::vd(author::$role, 1);
        // die;

        res::$ret[__FUNCTION__]  =   $menu;
    }
    




    static function lineHtml()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        line::dbInit();
        
        res::$ret[__FUNCTION__]  =   line::html();
        // res::$ret[__FUNCTION__]  =   '<h6 class="access">403: доступ ограничен...</h6>';
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




    static function accessArray()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;

        access::dbInit();
        

        res::$ret[__FUNCTION__]  =   ["Какой то ответ в json"];
    }
    
    
    static function accessText()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        
        access::dbInit();
        

        res::$ret[__FUNCTION__]  =   access::asText();
    }



    static function logList()
    {
        if ( ! in_array(__FUNCTION__, req::$wait) )     return;
        if ( empty(pack::$start) )                      return;
        

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