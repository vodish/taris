<?php
class row
{
    public $file;
    public $list    =   array();
    public $parent  =   array();


    public function __construct($fileId)
    {
        
        # получить файл из базы
        #
        $this->file =   db::one("SELECT *  FROM `file`  WHERE `id` = " .db::v($fileId). " ");


        # получить все записи из базы
        #
        db::query("
            SELECT
                *
            FROM
                `row`
            WHERE
                `file` = " .db::v($fileId). "
            ORDER BY
                `order`
        ");

        while( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'file', 'order']));

            $this->list[ $v['id'] ] = $v;
            $this->parent[ $v['parent'] ] = $v['id'];
        }
        
    }




    public function actionSave()
    {
        if ( empty($_POST['rows']) )    return;

        $lines  =   $_POST['rows'];
        $lines  =   strtr($lines, ["\r"=>'']);
        $lines  =   explode("\n", $lines);
        
        $id     =   '';
        $id5    =   '';

        foreach( $lines as $v )
        {
            
        }


        load::vd($lines);

        load::vdd($_POST);

        die;
    }

}