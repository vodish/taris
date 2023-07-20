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
            db::cast($v, ['id'=>'int', 'parent'=>'int', 'is_project'=>'int', 'order'=>'int']);
            
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

            if ( $pack['is_project'] )   $bc[] = $pack;
        }

        
        return $this->bc = $bc;
    }

    


}