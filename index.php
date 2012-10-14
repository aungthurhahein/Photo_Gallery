<?php
	//testing the db functions
  require_once('includes/database.php');
  require_once('includes/user.php');
  
  //if(isset($database)){echo "true<br/>";}else{echo "false <br/>";} 
  //echo $database->escape_value("It's working or not!!<br/>");
  //testing first entry
 // $query ="INSERT INTO Users(id,username,password,first_name,last_name)"; 
  //$query .= "Values (1,'atrx','41087','aung','hein')";
  //$result= $database->query($query);
  //retrieve it.
  
  $user = User::find_by_id(1);
  echo $user->full_name();
  
  
  /* echo $found_user['username'];
  $users_set = User::find_all();
  while($user= $database->fetch_array($users_set)){
  	echo "User:".$user['username']."<br/>";
  	echo "Name:".$user['first_name']."".$user['last_name']."<br/><br/>";
  } */
  /*
  $sql ="Select * from Users where id = 1";
  $result_set = $database->query($sql);
  $user_find = $database->fetch_array($result_set);
  echo $user_find['username'];
  */
?>
