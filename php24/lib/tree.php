<?php
class tree
{
    # получить дерево проекта как массив для json
    #
    static function array( $start,  $level=0,  $arr=array() )
    {
        
        $children   =   pack::$parent[ $start ] ??  array();
        

        foreach( $children as $id )
        {
            $name       =   pack::$list[ $id ]['name'];
            $isProject  =   pack::$list[ $id ]['is_project'];
            $sub        =   pack::$parent[ $id ] ?? null;
            
            $arr[]      =   ['id'=>$id, 'project'=>$isProject, 'level'=>$level];;

            pack::toHeap(['id'=>$id, 'name'=>$name]);
            
            
            if ( !$isProject  && isset($sub) )
            {
                $arr   =   self::array($id, ($level+1), $arr);
            }
        }
        
        return $arr;
    }



    # получить дерево проекта как текст
    #
    static function asText( $start,  $level=0,  $text='' )
    {
        $children   =   pack::$parent[ $start ] ??  array();
        
        foreach( $children as $id )
        {
            $isProject  =   pack::$list[ $id ]['is_project'];
            $sub        =   pack::$parent[ $id ] ?? null;

            $text       .=  str_repeat(" ", $level*4).  pack::$list[ $id ]['name']. '  ' .$id. "\n";

            if ( !$isProject  && isset($sub) )
            {
                $text   =   self::asText($id, ($level+1), $text);
            }
        }


        return $text;
    }
}