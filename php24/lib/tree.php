<?php
class tree
{
    private static $log = [];


    # json дерево для лога
    #
    private static function log()
    {
        self::$log[]    =   json_encode(pack::$tree, JSON_UNESCAPED_UNICODE);
    }


    # сохранить записи в базу
    #
    private static function dbSave()
    {
        # текущее дерево
        self::log();
        
        if ( !isset(self::$log[1]) )            return;
        if ( self::$log[0] == self::$log[1] )   return;


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
                ," .db::v(self::$log[1]). "
            )
        ");
        


        # пересоздать дерево пачек
        #
        $rows   =   '';
        foreach( pack::$tree as $list )
        {
            foreach( $list as $pack )
            {
                $row = '';
                foreach($pack as $v)    $row .= ','. db::v($v);
                $rows .= ',('. substr($row, 1). ')'. "\n";
            }
        }
        $rows   =   substr($rows, 1);


        
        # обновить дерево
        #
        db::query("DELETE FROM `pack` WHERE `user` = " .db::v(user::$id) );
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
            " .$rows. "
        ");

    }







    # сохранить дерево с обновленной веткой пачек
    #
    static function save()
    {
        # отладка
        #
        // res::treeText();
        // req::$param['tree'] =   res::$ret['treeText'];
        


        if ( empty(pack::$start)            )   return;
        if ( !isset(req::$param['tree'])    )   return;
        

        # логировать текущее дерево
        self::log();


        # разбить текст по-строчно, каждая пачка на своей строке
        # вспомогательные переменные
        #
        $source     =   req::$param['tree'];
        $source     =   str_replace("\r", '', $source);
        $list       =   explode("\n", $source);
        $tree       =   array();
        $exist      =   array();

        

        # пройти по строкам
        #
        foreach( $list as $k => $ls )
        {
            # распарсить строки пачек
            # выдать новый id для новой записи
            #
            $v              =   self::parseline($ls);
            #
            $v['id']        =   $v['id']===null && !empty($v['name']) ?  user::nextid() : $v['id'];
            $v['user']      =   user::$id;
            $v['project']   =   pack::$project;
            $v['order']     =   $k + 1;
            $v['file']      =   isset(pack::$list[ $v['id'] ])?  pack::$list[ $v['id'] ]['file']:  0;
            #
            #
            $tree[]  =  $v;         # новое дерево проекта
            $exist[] =  $v['id'];   # только актуальные пачки
        }


        # заменить ветку в деревe
        # создать новый лог
        #
        pack::$tree[ pack::$project ]   =   $tree;
        

        # если удалена текущая пачка
        #
        if ( ! in_array(pack::$start, $exist) )
        {
            pack::$start    =   pack::$project;
            pack::$project  =   pack::$start;
            array_shift(pack::$bc);
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
        # пересортировать измененные проекты
        # 
        ksort( pack::$tree, SORT_NUMERIC );
        $k = 1;
        foreach(pack::$tree[ pack::$project ] as &$v)   $v['order'] = $k++;
        


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
        self::log();


        # добавить текущий проект в дерево над проекта
        $branch  =  array();
        #
        foreach( pack::$tree[ pack::$project ] as  $v )
        {
            $v['order'] =   count($branch) + 1;
            $branch[]   =   $v;

            if ( $v['id'] == pack::$start  && pack::$tree[ pack::$start ] )
            {
                foreach( pack::$tree[ pack::$start ] as $v2 )
                {
                    $v2['project']  =   pack::$project;
                    $v2['space']    +=  4 + $v['space'];
                    $v2['order']    =   count($branch) + 1;
                    $branch[]       =   $v2;
                }
            }
        }

        # удалить из дерева лишнюю ветку
        # добавить обновленную ветку
        #
        unset( pack::$tree[ pack::$start ] );
        pack::$tree[ pack::$project ] = $branch;


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