<?php
class tree
{
    private static $log = [];


    # актуальный проект
    #
    static function project()
    {
        $project    =  pack::$project == 0 ?  pack::$start :  pack::$project;
        $project    =  pack::$project > 0 && isset( pack::$tree[ pack::$start ] ) ?  pack::$start :  $project;

        return  $project;
    }


    # json дерево для лога
    #
    static function log()
    {
        
        # пересортировать дерево как есть
        # проверить дубли ид и принадлежность к пользователю
        #
        $ulen   =   strlen( user::$prefix );
        $double =   array();
        $order  =   1;
        #
        #
        foreach( pack::$tree as &$list )
        {
            
            foreach( $list as &$pack )
            {
                $pack['order']  =   $order++;

                # пропустить пустую строку
                #
                if ( $pack['id'] == null )  continue;

                # пересоздать ид пачки
                #
                if (    in_array($pack['id'], $double)
                    ||  substr($pack['id'], 0, $ulen) != strval(user::$prefix)
                    ||  $pack['id'] == user::$prefix
                )
                {
                    do      { $nextid = user::nextid(); }
                    while   ( in_array($nextid, $double) );

                    $pack['id'] =   $nextid;
                }

                $double[]   =   $pack['id'];
            }
        }
        
        

        self::$log[]    =   json_encode(pack::$tree, JSON_UNESCAPED_UNICODE);
    }



    # сохранить записи в базу
    #
    static function dbSave()
    {
        # текущее дерево
        #
        self::log();
        #
        #
        if ( !isset(self::$log[1]) )            return;
        if ( self::$log[0] == self::$log[1] )   return;
        

        # подготовить sql записи дерева
        #
        foreach( pack::$tree as $list )
        {
            foreach( $list as $pack )
            {
                if ( $pack['project'] == 0 )    continue;
                
                foreach($pack as &$v)  $v = db::v($v);
                
                $rows[] =   "(".  implode(',', $pack).  ")";
            }
        }
        #
        #
        // ui::vd( user::$prefix );
        // ui::vd( $rows );
        // die;
        


        # сохранить в лог
        #
        db::query("
            INSERT INTO `log` (
                 `user`
                ,`author`
                ,`author_email`
                ,`target`
                ,`row`
                ,`json`
            )
            VALUES (
                 " .db::v(user::$id). "
                ," .db::v(0). "
                ," .db::v('@'). "
                ," .db::v('tree'). "
                ," .db::v(null). "
                ," .db::v(self::$log[0]). "
            )
        ");
        #
        #
        # обновить дерево
        #
        db::query("
            DELETE
            FROM    `pack`
            WHERE   `user` = " .db::v(user::$id). " AND `project` != 0
        ");
        #
        #
        if ( empty($rows) )     return;
        #
        #
        db::query("
            INSERT INTO `pack` (
                 `user`
                ,`id`
                ,`project`
                ,`space`
                ,`name`
                ,`order`
                ,`file`
            )
            VALUES
            ".  implode("\n,", $rows).  "
        ");

    }





    # сохранить дерево с обновленной веткой пачек
    #
    static function upd()
    {
        if ( empty(pack::$start)            )   return;
        if ( !isset(req::$param['tree'])    )   return;
        

        # логировать текущее дерево
        #
        self::log();


        # разбить текст по-строчно, каждая пачка на своей строке
        # вспомогательные переменные
        #
        $project    =   self::project();
        $source     =   req::$param['tree'];
        $source     =   str_replace("\r", '', $source);
        $list       =   explode("\n", $source);
        $tree       =   array();
        $exist      =   array();

        

        # пройти по строкам
        #
        foreach( $list as $ls )
        {
            # распарсить строки пачек
            # выдать новый id для новой записи
            #
            $v              =   self::parseline($ls);
            #
            $v['id']        =   $v['id']===null && !empty($v['name']) ?  user::nextid() : $v['id'];
            $v['user']      =   user::$id;
            $v['project']   =   $project;
            $v['order']     =   0;
            $v['file']      =   isset(pack::$list[ $v['id'] ])?  pack::$list[ $v['id'] ]['file']:  0;
            #
            #
            $tree[]  =  $v;         # новое дерево проекта
            $exist[] =  $v['id'];   # только актуальные пачки
            #
            pack::$list[ $v['id'] ] =   $v;
        }


        # заменить ветку в деревe
        # создать новый лог
        #
        pack::$tree[ $project ]   =   $tree;
        
        


        # если удалена текущая пачка в проекте
        #
        if (  $project != pack::$start  &&  ! in_array(pack::$start, $exist) )
        {
            pack::$start    =   $project;
            pack::$project  =   pack::$list[ $project ]['project'];
            array_shift(pack::$bc);

            res::$ret['href']   =   '/'. $project;
        }
        
        

        # сохранить новое дерево проекта
        #
        self::dbSave();
        
    }




    # распарсить строчку пачки
    #
    private static function parseline($str)
    {
        preg_match("#^\s*#", $str, $_before);
        preg_match("#\s+\d+$#", $str, $_after);
        
        
        $space  =   strlen($_before[0]);
        $id     =   empty($_after[0]) ?  null : (int) trim($_after[0]);
        $name   =   mb_substr(
            $str,
            mb_strlen($_before[0]),
            isset($_after[0]) ? -mb_strlen($_after[0]): null
        );


        return [
            'user'      =>  null,
            'id'        =>  $id,
            'project'   =>  null,
            'space'     =>  $space,
            'name'      =>  $name,
            'order'     =>  null,
            'file'      =>  null,
        ];
    }






    
    # добавить проект
    # 
    static function add()
    {
        if ( ! pack::$start )   return;
        if ( @url::$level[1] !== 'treeAdd' )   return;


        # логировать текущее дерево
        #
        self::log();



        # выделить новую верту
        #
        $order  =  1;
        foreach( pack::$tree[ pack::$project ] as $k => $pack)
        {
            # новый проект
            if ( $pack['id'] == pack::$start )
            {
                $space  =  $pack['space']; 
                continue;
            }
            #
            # перенести вложения в новый проект
            #
            if ( isset($space) )
            {
                if ( $pack['space'] <= $space ) break;

                if ( $space < $pack['space'] )
                {
                    $pack['project']    =   pack::$start;
                    $pack['space']      =   ($s = $pack['space'] - $space - 4) > 0  ?  $s:  0;
                    $pack['order']      =   $order++;
                    
                    pack::$tree[ pack::$start ][]  =  $pack;

                    unset(pack::$tree[ pack::$project ][ $k ]);
                }
            }
        }
        #
        # если пока нет вложенных пачек
        #
        if ( !isset(pack::$tree[ pack::$start ]) )
        {
            pack::$tree[ pack::$start ][]   =   array_merge(self::parseline(''), ['user'=>user::$id, 'project'=>pack::$start]);
        }
        
        
        # пересортировать измененные проекты
        # 
        ksort( pack::$tree, SORT_NUMERIC );
        


        # новый путь для фронта
        #
        res::$ret['href']   =   '/'. pack::$start;


        # сохранить лог
        #
        self::dbSave();

    }




    # удалить проект
    # 
    static function del()
    {
        if ( ! pack::$start )   return;
        if ( @url::$level[1] !== 'treeDel' )   return;
        if ( !isset(pack::$tree[ pack::$project ]) )     return;


        # логировать текущее дерево
        #
        self::log();


        # добавить текущий проект в дерево над проекта
        $tree  =  array();
        #
        foreach( pack::$tree[ pack::$project ] as  $v )
        {
            $tree[]  =  $v;

            if ( $v['id'] == pack::$start  &&  isset(pack::$tree[ pack::$start ]) )
            {
                foreach( pack::$tree[ pack::$start ] as  $v2 )
                {
                    $v2['project']  =   pack::$project;
                    $v2['space']    +=  4 + $v['space'];
                    $tree[]         =   $v2;
                }
            }
        }

        # удалить из дерева лишнюю ветку
        # добавить обновленную ветку
        #
        unset( pack::$tree[ pack::$start ] );
        pack::$tree[ pack::$project ]  =  $tree;


        // ui::vd( pack::$tree[ pack::$project ] );
        // ui::vd( pack::$tree[ pack::$start ] );
        // ui::vd( $branch );



        # новый путь для фронта
        #
        res::$ret['href']   =   '/'. pack::$start;


        # сохранить лог
        #
        self::dbSave();

    }


    

}