<?php
class pack
{
    public $user;
    public $list;
    public $parent;


    public function __construct($user)
    {
        $this->user =   $user;


        db::query("
            SELECT
                *
            FROM
                `pack`
            WHERE
                `user` = " .db::v($user). "
            ORDER BY
                `order`
        ");


        while ( $v = db::fetch() )
        {
            $this->list[ $v['id'] ] =   $v;

            $this->parent[ $v['parent'] ][] =   $v['id'];
        }

    }
}