<?php
class db_pdo
{
	public	$connect;
	public  $dsn;
	public	$statement;
	public	$error;
	public  $sqlText;
    public  $log;
    
    
    
    public function __construct($dsn='taris_test')
    {
        # [PDO]  // into php.ini
        $this->dsn      =   $dsn;
        // $this->dsn      =   'taris_prod';

		try {
        	@$this->connect  =   new PDO($dsn, $user??null, $pass??null, [ PDO::ATTR_EMULATE_PREPARES => true ]);
		}
		catch (Exception $e) {
			echo '<b>Cant connect to db...</b><br />';
			die( $e->errorInfo[2] ?? '' );
		}
    }
	
	
    
    
	public function select($sql, $params=[])
	{
	    $this->query($sql, $params);
	    
	    $data  =   $this->statement->fetchAll(PDO::FETCH_ASSOC);
	    
	    return $data;
	}
	
	
	public function one($sql, $params=[])
	{
	    $this->query($sql, $params);
	    
	    $data  =   $this->statement->fetch(PDO::FETCH_ASSOC);
	    
	    
	    return $data ? $data : array();
	}
	
	
	public function query($sql, $params=[])
	{
	    $sqlText       =   $this->sqlText($sql, $params);
	    $start         =   microtime(true);
	    
	    $this->statement  =   $this->connect->prepare($sql);
		
		try {
			$this->statement->execute($params) || $this->printSql($sqlText);
		}
		catch (Exception $e) {
			$this->printSql($sqlText);
		} 
		
	    $finish        =   microtime(true);
	    $this->log[]   =   array($sql, ($finish-$start));
	}
	
	
	public function fetch()
	{
	    $data  =   $this->statement->fetch(PDO::FETCH_ASSOC);
	    
	    return $data;
	}
	

	public function lastId()
	{
		return $this->connect->lastInsertId();
	}

	# escape 
	#
	public function v($val)
	{
	    if ( is_null($val)	)   return 'NULL';
	    if ( is_int($val) 	)   return $val;
	    
	    return $this->connect->quote($val);
	}
	
	
	
	
	
	# sql text with params into sql for debug
	#
	private function sqlText($sql, $params)
	{
	    foreach ($params as $k=>$v)
	    {
	        $k     =   strpos($k, ':')===false ?  ':'.$k  :  $k;
	        $v     =   is_string($v) ?  $this->connect->quote($v) : $v;
	        $v     =   is_null($v) ?  'NULL' : $v;
	        
	        $sql   =   str_replace( $k, ($v.'/*'.$k.'*/'), $sql );
	    }
	    
	    
	    return $sql;
	}
	
	
	public function printSql($sqlText)
	{
	    if ( PATH_SEPARATOR==';' )
	    {
	        $this->error   =   $this->statement->errorInfo();
	        $this->error[] =   $sqlText;
	    }
	    else
	    {
	        $this->error   =   ['Database error...'];
	    }
	    
		$backtrace	=	debug_backtrace();
		$fileline	=	'';
		foreach($backtrace as $v)
		{
			if ( $v['class'] !== 'db_pdo' )
			{
				$fileline = $v['file']. '::' .$v['line'];
				break;
			}
		}


	    echo '<pre style="color: maroon;">';
			echo "\n\n";
			echo $fileline;
			echo "\n";
			print_r($this->error);
			echo "\n\n";
			echo '</pre>';
	    die;
	}
	
	# escape " for attribute value: value="?"
	#
	public function v2input($value)
	{
		return	str_replace('"', '&#034;', $value);
	}
    

	# для php7 преобразовать типы
	# $types = array( 'int'=>['field_name', 'field_name'...], 'str'=>['field_name', 'field_name'...] )
	#
	public function cast(&$row, array $types)
	{
		if ( empty($row) )	return $row;
		
		
		foreach(['int', 'str'] as $type)
		{
			if ( !isset( $types[ $type ]) )		continue;
			
			foreach($types[ $type ] as $key)
			{
				if ( $row[ $key ] === null )	continue;

				if ( $type=='int' )	$row[ $key ]	=	intval($row[ $key ]);
				if ( $type=='str' )	$row[ $key ]	=	strval($row[ $key ]);
			}
		}
		
	}
}
