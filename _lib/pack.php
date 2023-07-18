<?php
class pack
{
    public $user;
    public $list;
    public $parent;



    # получить все пачки пользователя
    #
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


    # определить текущий проект
    #
    public function getProjectBc($start)
    {
        $bc =   array();

        while( isset($this->list[ $start ]) )
        {
            $pack   =   $this->list[ $start ];
            $start  =   $pack['parent'];

            if ( $pack['id'] == $pack['project'] )   $bc[] = $pack;
        }

        
        return $bc;
    }


    # получить дерево проектов
    #
    public function getProjectMap()
    {
        
    }


}