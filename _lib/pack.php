<?php
class pack
{
    public $start;
    public $user;
    public $project =   null;
    
    public $list    =   array();
    public $parent  =   array();
    public $bc      =   array();
    

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
        #
        #
        while ( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'is_project', 'order']));
            
            $this->list[ $v['id'] ] =   $v;
            $this->parent[ $v['parent'] ][] =   $v['id'];
        }

        
        # свойства проекта
        #
        $this->start    =   $start;
        $this->user     =   $this->list[ $start ]['user'] ?? null;
        


        # определить крошки проекта
        # определить текущий проект
        #
        $packId =   $start;
        #
        while( isset($this->list[ $packId ]) )
        {
            $pack       =   $this->list[ $packId ];
            $packId     =   $pack['parent'];

            if ( !$pack['is_project'] )     continue;
            
            $this->bc[] =   $pack['id'];
        }
        #
        $this->project  =   $this->bc[0];


    }
    
    public function getTitle()
    {
        $projectName    =   $this->list[ $this->project ]['name'];
        $packName       =   $this->list[ $this->start ]['name'];

        return $projectName. ' / '. $packName;
    }
}