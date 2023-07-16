<?php
class project
{
    public $id;
    public $list;
    public $parent;

    public function __construct($id)
    {
        $this->id   =   $id;

        db::query("
            SELECT
                *
            FROM
                `pack`
            WHERE
                " .db::v($id). " IN (`id`, `project`)
            ORDER BY
                IF(`id`=" .db::v($id). ", 1, 2)
                ,`order`
        ");

        while ( $v = db::fetch() )
        {
            $this->list[ $v['id'] ] = $v;

            $this->parent[ $v['parent'] ][] = $v['id'];
            // load::vd($v);
        }
    }


    public function getTextTree( $start,  $level=0,  $text='' )
    {
        if ( !isset($this->parent[ $start ]) )  return $text;

        foreach( $this->parent[ $start ] as $id )
        {
            $text   .=  str_repeat(" ", $level*4). $this->list[ $id ]['name']. ' ' .$id. "\n";

            $text   =   $this->getTextTree($id, ($level+1), $text);
        }

        return $text;
    }


}