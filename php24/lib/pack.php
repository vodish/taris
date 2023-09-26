<?php
class pack
{
    ############################################################
    # фасад
    

    /** @var pack */
    static $pack;


    static function init($start=null)
    {
        if ( empty(req::$param['pack']) && $start==null )   return;

        $start  =   $start  ??  req::$param['pack'];

        self::$pack = new pack($start);
    }
    

    static function toHeap($pack)
    {
        self::$pack->heap[ $pack['id'] ]  =   array(
            'id'    =>  $pack['id'],
            'name'  =>  $pack['name'],
        );
    }




    ############################################################
    # объект
    
    public $start;
    public $list;
    public $parent;
    public $bc;
    public $heap;
    public $project;
    public $user;
    public $file;

    
    function __construct($start)
    {
        # получить все пачки пользователя
        #
        #
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
    
            pack::toHeap($pack);
        }
        #
        #
        $this->start    =   $start;
        $this->project  =   $this->bc[0];
        $this->user     =   $this->list[ $start ]['user'];
        $this->file     =   $this->list[ $start ]['file'];
    
    
        # добавить в крошки открытую пачку, если она не проект
        #
        if ($this->bc[0] != $start )    array_unshift($this->bc , $start);
        
    }


    

    





    static function api()
    {
        if ( ! url::start('/api') )     return;
        if ( empty($_POST['pack']) )    return;
        if ( $_POST['pack'] < 1 )       return;
        
        
        
        # получить все пачки
        #
        pack::init( $_POST['pack'] );
        
        # сохранить содержание
        #
        line::apiSave();
        
        # сохранить дерево
        #
        if ( isset($_POST['tree']) )
        {
            # передать на обработку
            # перечитать пачку
            project::init();
            project::makeRows($_POST['tree']);
            pack::init( pack::$start ); // здесь подставлять ид проекта, если удалена текущая пачка
        }


        # вернуть состояние
        #
        $wait   =   $_POST['wait'] ?? [];

        if ( in_array('pack', $wait) )
        {
            ui::$json['pack']['start']      =   pack::$start;
            ui::$json['pack']['title']      =   project::setTitle();
            ui::$json['pack']['project']    =   pack::$project;
            ui::$json['pack']['bc']         =   array_reverse(pack::$bc);
            ui::$json['pack']['tree']       =   project::treeArray( pack::$project );
            ui::$json['pack']['heap']       =&  pack::$heap;
        }
        

        if ( in_array('lineHtml', $wait) )    ui::$json['lineHtml']   =   line::asHtml();
        if ( in_array('lineText', $wait) )    ui::$json['lineText']   =   line::asText();
        if ( in_array('treeText', $wait) )    ui::$json['treeText']   =   project::treeText( pack::$project );
        if ( in_array('accessText', $wait) )  ui::$json['accessText'] =   "access pack::api() access";


    }


    

}