<?php

class db
{
	public $result = Array();
	private $connect;
	
	public function __construct($_host=false, $_user=false, $_pass=false, $_name=false)
	{
		$config = registry::register("config");
		
		$host = $config->db_host;
        $user = $config->db_user;
        $pass = $config->db_pass;
        $name = $config->db_name;
		
		if(!isset($host))
		{
			$host = $_host;
            $user = $_user;
            $pass = $_pass;
            $name = $_name;
		}
		
		if($host === false)
		{
			die('Nie przekazano danych dostępowych do bazy.');
		}
		
		$this->connect = new mysqli($host, $user, $pass, $name);
		if(mysqli_connect_errno() !== 0)
		{
			throw new Exception("Błąd połączenia z bazą danych : ".mysqli_connect_error());
		}
		else
		{
			$this->connect->query("SET NAMES 'utf8'");
			return $this->connect;
		}
	}

	public function getLastInsertedId() {
		return mysqli_insert_id($this->connect);
	}

	public function querymy($sql)
	{
		$query_arr = explode(" ", trim($sql));
		$query_type = strtoupper($query_arr[0]);
		
		if($query_type == 'SELECT' || $query_type == 'SHOW')
		{
			$this->result = array();
		
			$wynik = $this->connect->query($sql);
			return $wynik;
		}
		else if($query_type == 'UPDATE' || $query_type == 'DELETE' || $query_type == 'DROP' || $query_type == 'INSERT' || $query_type == 'ALTER' || $query_type == 'CREATE')
		{
			return $this->modifiable($sql);
		}
		
		return false;
	}
	
	public function execute($sql)
	{
		$query_arr = explode(" ", trim($sql));
		$query_type = strtoupper($query_arr[0]);
		
		if($query_type == 'SELECT' || $query_type == 'SHOW')
		{
			return $this->selectable($sql);
		}
		else if($query_type == 'UPDATE' || $query_type == 'DELETE' || $query_type == 'DROP' || $query_type == 'INSERT' || $query_type == 'ALTER' || $query_type == 'CREATE')
		{
			return $this->modifiable($sql);
		}
		
		return false;
	}
	
	private function selectable($query)
	{
		$this->result = array();
		
		$wynik = $this->connect->query($query);
		if(!$wynik)
		{
			return false;
		}
		else
		{
			while (($db_result = $wynik->fetch_assoc()) !== null)
			{
				array_push($this->result, $db_result);
				//$this->result[] = $db_result;
			}
			
			return $this->result;
		}
		
		$this->close();
	}
	
	private function modifiable($query)
	{
		$this->result = array();
		
		$wynik = $this->connect->query($query);
		return (!($wynik)) ? false : true;
	}
	
	public function getRow()
	{
		$row = mysqli_fetch_row($this->result);
		return $row;
	}
	
	public function count()
	{
		$count = count($this->result);
		return (!$count || !is_int($count)) ? 0 : $count;
	}
	
	public function close()
	{
		if($this->connect) mysqli_close($this->connect);
	}
	
	public function __destruct()
	{
		$this->close();
	}
}

?>