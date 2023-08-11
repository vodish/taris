<?php
class access
{
    /**  @var pack $pack */
    private $pack;

    public $bc;

    public function __construct(pack &$pack)
    {
        $this->pack =   $pack;

        # распарсить права
        #
        foreach( $this->pack->bc as $proId )
        {
            $this->bc[] =   yaml_parse($this->pack->list[ $proId ]['access_yaml']);
        }
        
        
        // load::vd($this->bc, 1);

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
        if ( !isset($_POST['access']) )      return;
        
        db::query("
            UPDATE
                `pack`
            SET
                `access_yaml` = " .db::v($_POST['access']). "
            WHERE
                `id` = " .db::v($this->pack->project). "
        ");

        // load::vdd($_POST);


        url::redir( url::$dir[1],  null, ['save'=>time()] );
    }
    
}