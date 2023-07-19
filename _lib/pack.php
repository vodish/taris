<?php
class pack
{
    public $user;
    public $list;
    public $parent;

    public $start;
    public $bc;
    

    # получить все пачки пользователя
    #
    public function __construct($user, $start=null)
    {
        $this->user     =   $user;
        $this->start    =   $start;


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


    # определить текущий проект
    #
    public function getProjectBc($start)
    {
        $bc     =   array();

        while( isset($this->list[ $start ]) )
        {
            $pack   =   $this->list[ $start ];
            $start  =   $pack['parent'];

            if ( $pack['id'] == $pack['project'] )   $bc[] = $pack;
        }

        
        return $this->bc = $bc;
    }


    # получить дерево проектов
    #
    public function getProjectMap()
    {
        
    }


}