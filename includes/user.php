<?php
require_once 'database.php';
class User{
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	
	//retrieve all user data from table
	public static function find_all(){
		global $database;
		$resultset= $database->query("SELECT * from Users");
		return $resultset; 
	}	
	//retrieve specific user from table
	public static function find_by_id($id=0){
		global $database;
		$result_array = self::find_by_sql("SELECT * FROM users WHERE id = {$id} LIMIT 1");		
		return !empty($result_array)? array_shift($result_array): false;
	}
	
	//find with sql
	public static function find_by_sql($sql=""){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row =$database->fetch_array($result_set)){
			$object_array[]= self::instantiate($row);
		}
		return $object_array;
	}
	
	//fullname
	public function full_name(){
		if(isset($this->first_name) && isset($this->last_name)){
			return $this->first_name."".$this->last_name;
		}else{
			return "";
		}
		
	}
	//make an instance
	private static function instantiate($record){
		$object = new self;
		/* 
		$object->id        = $record['id'];
		$object->username  = $record['username'];
		$object->password  = $record['password'];
		$object->first_name= $record['first_name'];
		$object->last_name =$record['last_name']; */
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	//check values exists or not
	private function has_attribute($attribute){
		//method which return associate array with all attributes
		$object_var = get_object_vars($this);
		return array_key_exists($attribute, $object_var);		
	}
	
}
?>