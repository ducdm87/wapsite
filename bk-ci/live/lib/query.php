<?php

class JObject extends mosDBTable
{
	function JObject(&$database,$table,$key='id')
	{
		$this->mosDBTable($table,$key,$database);
	}
	function store($show=0)
	{
		$sql	= '';
		$exe	= '';
		$obj 	= get_object_vars($this);
		
		foreach($obj as $k => $v)
		if(strpos($k,'_') !== 0 && is_null($v) == false)
		{
			$sql.= '`'.$k.'`='.$this->_db->Quote($v);
			$sql.= ',';
			$exe.= $k.':'.$v." \t ";
		}
		
		$sql = rtrim($sql,',').' ';
		
		if($show) echo 'JObject: '.$this->_tbl.': '.$exe.'<br/>';
		
		$query = 'INSERT INTO '.$this->_tbl.' SET ' . $sql;
		$query.= 'ON DUPLICATE KEY UPDATE ' . $sql;
		
		$this->_db->setQuery($query);

		if (!$this->_db->query()) {
			echo nl2br($this->_db->getQuery().'<br/>');
			echo nl2br($this->_db->getErrorMsg().'<br/>');
		}
	}	
}