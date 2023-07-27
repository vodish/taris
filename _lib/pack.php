<?php
class pack
{
    public $start;
    public $bc;
    
    public $user;
    public $list    =   array();
    public $parent  =   array();


    # получить все пачки пользователя
    #
    public function __construct($start)
    {

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


        while ( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'is_project', 'order']));
            
            $this->list[ $v['id'] ] =   $v;
            $this->parent[ $v['parent'] ][] =   $v['id'];
        }

        
        $this->start    =   $start;
        $this->user     =   $this->list[ $start ]['user'] ?? null;
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