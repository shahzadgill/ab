<?php
	class Database{
		public $dbh;
		function __construct(){
			/*$servername = 'localhost';
			$username = 'wahgunsc_shahzad';
			$password = 'itm1234';
			$dbname = 'wahgunsc_shahzad1';*/
			$servername = 'localhost';
			$username = 'root';
			$password = '';
			$dbname = 'addressbook';
			$this->dbh = new mysqli($servername, $username, $password, $dbname);
				if ($this->dbh->connect_error) {
	    		die("Connection failed: " . $this->dbh->connect_error);
			} 
		}
		
		//Insert Data Into Table
		function mysql_insert_array($table, $data, $exclude = array()) {
			if (count($data) > 0) {
			$fields = $values = array();
			if( !is_array($exclude) ) $exclude = array($exclude);
			foreach( array_keys($data) as $key ) {
				if( !in_array($key, $exclude) ) {
					$fields[] = "`$key`";
					$values[] = "'" . mysqli_real_escape_string($data[$key]) . "'";
				}
			}
			$fields = implode(",", $fields);
			$values = implode(",", $values);
			if( $this->dbh->query("insert into `$table` ($fields) values ($values)")) {
				return array( "mysqli_error" => false, "mysqli_insert_id" => mysqli_insert_id(), "mysqli_affected_rows" => mysqli_affected_rows(), "mysqli_info" => mysqli_info() );
			}
			else {
				die("Insert Error");
			}
			}
			else{
				die("No Data in Array");
			}
		}

		//Update Single Row
		function mysql_update_row($table,$data,$where) {
	        if (count($data) > 0) {
	            foreach ($data as $key => $value) {
	                $value = mysqli_real_escape_string($value);
	                $value = "'$value'";
	                $updates[] = "$key = $value";
	            }

	        $implodeArray = implode(', ', $updates);
	        if($this->dbh->query("update `$table` set $implodeArray where $where ") ) {
				return true;
			}
			else {
				return false;
			}
	        }
		}

		//Delete Single Row
		function mysql_delete_row($table,$where){
			$result = $this->make_query("delete from $table where $where");
			if ($result) {
				return true;
			}
			else{
				return false;
			}
		}

		//Get Single Row Data
		function mysql_get_row($table,$columns,$where){
			$result = $this->make_query("select $columns from $table where $where");
			$row = mysqli_fetch_array($result);
			if ($row) {
				return $row;
				
			}
			else{
				return false;
				//die("Get Row Error");
			}
		}

		function fetch($result){
			//die('here');
			return mysqli_fetch_array($result);
		}

		//Get All Data Of Table
		function mysql_get_all($table,$where){
			$result = $this->make_query("select * FROM $table WHERE $where");
			return $result;
		}

		//Make Own Query
		function make_query($q){
			$query=$this->dbh->query($q);
			if(!$query){
				return false;
			}
			else{
				return $query;
			}
		}
		function last_id(){
			return $this->dbh->insert_id;
		}
	}
	$db=new Database();
	foreach($_REQUEST as $key=>$value){
		if(is_string($value))
			//$_REQUEST[$key]=mysql_real_escape_string($value);
			$_REQUEST[$key]=mysqli_real_escape_string($value);
	}
?>