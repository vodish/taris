<?php
class access
{
    private $pack;
    

    public function __construct(pack &$pack)
    {
        $this->pack =   $pack;

        $yaml       =   $pack->list[ $pack->project ]['access_yaml'];
        $parse      =   yaml_parse($yaml);

        // load::vd(yaml_parse($yaml), 1);

    }
    


    # добавить ссылку
    #
    public function actionCreateLink()
    {
        if ( !isset($_GET['createAccessLink']) )     return;

        load::vdd($_GET);
    }



    # сохранить права
    #
    public function actionSave()
    {
        if ( empty($_POST['access']) )      return;
        
        db::query("
            UPDATE
                `pack`
            SET
                `access_yaml` = " .db::v($_POST['access']). "
            WHERE
                `id` = " .db::v($this->pack->project). "
        ");

        // load::vdd($_POST);

        
        url::redir( url::$dir[1]. url::fset(['save'=>time()]) );
    }
    
}