<?php
class access
{

    static function dbList($packBc)
    {
        $packBc =   empty($packBc)? [null]: $packBc;

        # получить все запии из таблицы прав
        #
        db::query("
            SELECT
                *
            FROM
                `access`
            WHERE
                `pack` IN (" .implode(",", $packBc). ")
            ORDER BY
                `id`
        ");

        while( $v = db::fetch() )
        {
            $list[ $v['pack'] ][ ] =  $v; 
        }


        return $list;
    }
    


    # добавить ссылку
    #
    static function actionCreateLink()
    {
        if ( !isset($_GET['createAccessLink']) )     return;

        load::vdd($_GET);
    }



    # сохранить права
    #
    static function actionSave($proId)
    {
        if ( !isset($_POST['access']) )      return;
        
        db::query("
            UPDATE
                `pack`
            SET
                `access_yaml` = " .db::v($_POST['access']). "
            WHERE
                `id` = " .db::v($proId). "
        ");

        // load::vdd($_POST);


        url::redir( url::$dir[1],  null, ['save'=>time()] );
    }
    
}