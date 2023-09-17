<?php
class pack
{
    # by init()
    static $list;
    static $parent;
    static $bc;
    static $heap;
    static $start;
    static $project;
    static $user;
    static $file;

    
    


    # получить все пачки пользователя по url
    #
    static function init($start)
    {
        pack::$list     =   array();
        pack::$parent   =   array();
        pack::$bc       =   array();
        pack::$heap     =   array();

        # получить все пачки пользователя
        #
        #
        db::query("
            SELECT
                *
            FROM
                `pack`
            WHERE
                `user` = (SELECT `user`  FROM `pack`  WHERE `id` = " .db::v($start). ")
            ORDER BY
                `order`
        ");
        #
        #
        while ( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'is_project', 'order']));
            
            pack::$list[ $v['id'] ] =   $v;
            pack::$parent[ $v['parent'] ][] =   $v['id'];
        }
        

        # определить крошки проекта
        # определить текущий проект
        #
        $packId =   $start;
        #
        while( isset(pack::$list[ $packId ]) )
        {
            $pack       =   pack::$list[ $packId ];
            $packId     =   $pack['parent'];

            if ( !$pack['is_project'] )     continue;
            
            pack::$bc[] =   $pack['id'];

            pack::toHeap($pack);
        }
        #
        #
        pack::$project  =   pack::$bc[0];
        pack::$start    =   $start;
        pack::$user     =   pack::$list[ $start ]['user'];
        pack::$file     =   pack::$list[ $start ]['file'];


        # открытая пачка
        #
        if (pack::$bc[0] != $start )    array_unshift(pack::$bc , $start);

    }
    

    static function toHeap($pack)
    {
        pack::$heap[ $pack['id'] ]  =   array(
            'id'    =>  $pack['id'],
            'name'  =>  $pack['name'],
        );
    }





    static function api()
    {
        if ( ! url::start('/api') )     return;
        if ( empty($_POST['pack']) )    return;
        if ( $_POST['pack'] < 1 )       return;
        
        
        
        # получить все пачки
        #
        pack::init( $_POST['pack'] );
        
        # сохранить содержание
        #
        line::apiSave();
        
        # сохранить дерево
        #
        if ( isset($_POST['tree']) )
        {
            # передать на обработку
            # перечитать пачку
            project::init();
            project::makeRows($_POST['tree']);
            pack::init( pack::$start ); // здесь подставлять ид проекта, если удалена текущая пачка
        }


        # вернуть состояние
        #
        $wait   =   $_POST['wait'] ?? [];

        if ( in_array('pack', $wait) )
        {
            ui::$json['pack']['start']      =   pack::$start;
            ui::$json['pack']['title']      =   project::setTitle();
            ui::$json['pack']['project']    =   pack::$project;
            ui::$json['pack']['bc']         =   array_reverse(pack::$bc);
            ui::$json['pack']['tree']       =   project::treeArray( pack::$project );
            ui::$json['pack']['heap']       =&  pack::$heap;
        }
        

        if ( in_array('lineHtml', $wait) )    ui::$json['lineHtml']   =   line::asHtml();
        if ( in_array('lineText', $wait) )    ui::$json['lineText']   =   line::asText();
        if ( in_array('treeText', $wait) )    ui::$json['treeText']   =   project::treeText( pack::$project );
        if ( in_array('accessText', $wait) )  ui::$json['accessText'] =   "access pack::api() access";


    }


    

}