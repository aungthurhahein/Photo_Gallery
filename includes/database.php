<?php
	require_once("config.php");
	
	class MySQLDatabase{
	//some variables
		private $connection;
		public $last_query;
		private $magic_quotes_active;
		private $release_escape_strings_exists;
		
	//Public Functions	
		//put some stuffs after object loadzzzzz
		function __construct(){
			$this->open_connection();
			$this->magic_quotes_active = get_magic_quotes_gpc();
			$this->release_escape_strings_exists = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
			
		}
			 
		//Create Database connection and select the databse
		public function open_connection(){ 
			$this->connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		 	if(!$this->connection){
		 		die("Database connection failed:". mysql_error());
		 	}
		 	else{
		 		$db_select = mysql_select_db(DB_NAME, $this->connection);
		 		if(!$db_select){
		 			die("Database selection failed;" . mysql_error());
		 		}
		 		
		 	}
			
		}
		//Close Database Connection
		public function close_connection(){
			if(isset($this->connection)){
				mysql_close($this->connection);
				unset($this->connection);
			}
			
		}
		//Perform Database Query
		public function query($sql){
			$this->last_query = $sql;
			$result = mysql_query($sql,$this->connection);
			$this->confirm_query($result);
			return $result;
		}
		
		//copy from internet. :D this fun: clean up the value for db query
		public function escape_value( $value ) {
			if( $this->release_escape_strings_exists ) { // PHP v4.3.0 or higher
				// undo any magic quote effects so mysql_real_escape_string can do the work
				if( $this->magic_quotes_active ) {
					$value = stripslashes( $value );
				}
				$value = mysql_real_escape_string( $value );
			} else { // before PHP v4.3.0
				// if magic quotes aren't already on then add slashes manually
				if( !$this->magic_quotes_active ) {
					$value = addslashes( $value );
				}
				// if magic quotes are active, then the slashes already exist
			}
			return $value;
		}
		
		
		//fetch data from query output 
		public function fetch_array($result_set){
			return mysql_fetch_array($result_set);			
		}
		//get row count from query output
		public function num_row($result_set){
			return mysql_num_rows($result_set);
		}
		//get last inserted id over the current db con
		public function insert_id($result_set){
			return mysql_insert_id($this->connection);
		}
		
	//Private Functions	
		//Query failure function for above method
		private function confirm_query($temp_result){
			if(!$temp_result){
				$output = "Database query execution failed:". mysql_error(). "<br/><br/>";
				$output .= "Last runned Query:" . "$this->last_query";
				die($output); 
			}
		}	
}	
	
	//make instance of DB
	$database = new MySQLDatabase();
?>