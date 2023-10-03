<?php
class db
{
    /** @var db_pdo */
    static $db;
    
    static function init()
    {
        self::$db = new db_pdo();
    }
    
    static function query($query, $vars=array())
    {
        self::$db->query($query, $vars);
        
        return self::lastId();
    }
    
    static function fetch($types=[])
    {
        $row    =   self::$db->fetch();
        self::$db->cast($row, $types);
        
        return  $row;
    }
    
    static function select($query, $params=[])
    {
        return self::$db->select($query, $params);
    }
    
    static function one($query, $vars=array())
    {
        return self::$db->one($query, $vars);
    }
    
    static function lastId()
    {
        return self::$db->lastId();
    }
    
    static function v($value)
    {
        return self::$db->v($value);
    }
    
    static function v2input($value)
    {
        return self::$db->v2input($value);
    }
    
    static function cast(&$row, array $types )
    {
        return self::$db->cast($row, $types);
    }
    
}