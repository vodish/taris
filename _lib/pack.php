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


        while ( $v = db::fetch() )
        {
            db::cast($v, array('int'=>['id', 'parent', 'is_project', 'order']));
            
            $this->list[ $v['id'] ] =   $v;
            $this->parent[ $v['parent'] ][] =   $v['id'];
        }

        
        $this->start    =   $start;
        $this->user     =   $this->list[ $start ]['user'] ?? null;


        $this->bcProject( $start );
        
    }


    # определить крошки проекта
    # определить текущий проект
    #
    private function bcProject($id)
    {
        
        while( isset($this->list[ $id ]) )
        {
            $pack   =&  $this->list[ $id ];
            $id     =   $pack['parent'];

            if ( !$pack['is_project'] )     continue;
            
            $this->bc[]         =   $pack['id'];
            // $pack['access_arr'] =   yaml_parse($pack['access_yaml']);
        }

        
        # текущий проект из крошек
        #
        $this->project  =   $this->bc[0];
        

        return $this->bc;
    }

    


}