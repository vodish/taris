<?php
class pack
{
    static $start;
    static $project;
    static $user;
    
    static $list    =   array();
    static $parent  =   array();
    static $bc      =   array();
    


    # получить все пачки пользователя по url
    #
    static function init()
    {
        if      ( pack::$start )    return;
        if      ( isset(url::$level[0])  && is_numeric(url::$level[0]) )                    $start = url::$level[0];
        elseif  ( url::start('/api')  && !empty($_POST['pack'])  && $_POST['pack'] > 0 )    $start = $_POST['pack'];
        #
        if      ( ! isset($start) )   return;



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

        }
        #
        #
        pack::$project  =   pack::$bc[0];
        pack::$start    =   $start;
        pack::$user     =   pack::$list[ $start ]['user'];



        # ui
        #
        ui::$json["packId"]         =   $start;
        ui::$json["packTitle"]      =   project::setTitle();
        ui::$json["packBc"]         =   project::apiBc();
        ui::$json["packTree"]       =   project::treeArray(pack::$project);
        ui::$json["packView"]       =   'отобразить содержание в html'; //line::asHtml();
        

    }
    



}