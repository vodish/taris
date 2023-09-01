<?php
class pack
{
    static $start;
    static $project;
    static $user;
    
    static $list    =   array();
    static $parent  =   array();
    static $bc      =   array();
    static $heap    =   array();
    


    # получить все пачки пользователя по url
    #
    static function init($start)
    {

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
        

        # получить все пачки про
        #
        pack::init( $_POST['pack'] );
        

        # ui
        #
        // line::dbInit();
        ui::$json['pack']['start']      =   pack::$start;
        ui::$json['pack']['title']      =   project::setTitle();
        ui::$json['pack']['project']    =   pack::$project;
        ui::$json['pack']['bc']         =   array_reverse(pack::$bc);
        ui::$json['pack']['tree']       =   project::treeArray( pack::$project );
        ui::$json['pack']['heap']       =&  pack::$heap;
        

        if ( isset($_POST['lineHtml']) )    ui::$json['lineHtml']   =   line::asHtml();
        if ( isset($_POST['lineText']) )    ui::$json['lineText']   =   line::asText();
        if ( isset($_POST['treeText']) )    ui::$json['treeText']   =   project::treeText( pack::$project );
        if ( isset($_POST['accessText']) )  ui::$json['accessText'] =   "access pack::api() access";

    }


}