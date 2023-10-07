<?php
class tree
{
    
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
        

        # текущее содержание
        # 
        $oldlog     =   self::toLog();


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
        #
        $newlog     =   self::toLog();
        

        # если удалена текущая пачка
        #
        if ( ! in_array(pack::$start, $exist) )
        {
            pack::$start    =   pack::$project;
            pack::$project  =   pack::$start;
            array_shift(pack::$bc);
        }
        


        // ui::vd( res::$ret['treeText'] );
        // ui::vd( $oldlog );
        // ui::vd( $newlog );
        // ui::vd( $oldlog == $newlog, 1 );
        // die;
        

        # сохранить новое дерево проекта
        #
        self::dbSave($oldlog, $newlog);
        
    }


    # json дерево для лога
    #
    private static function toLog()
    {
        $log    =   array();
        
        foreach( pack::$tree as $rows )
        {
            foreach( $rows as $r )  $log[] =  $r;
        }
        
        $log    =   json_encode($log, JSON_UNESCAPED_UNICODE);

        return $log;
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





    # сохранить записи в базу
    #
    private static function dbSave($oldlog, $newlog)
    {
        # сравнить изменилось ли дерево
        #
        if ( $oldlog == $newlog )  return;

        // ui::vd('# сохранить в лог');

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
                ," .db::v(user::$email). "
                ," .db::v('pack'). "
                ," .db::v(null). "
                ," .db::v($newlog). "
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

        // ui::vd('Обновить дерево хозяина');

    }


}