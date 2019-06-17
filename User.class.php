<?php

class User
{
	function __construct()
	{
		if (array_key_exists("user",$_SESSION)) {
       $this->username = $_SESSION["user"]["name"];
   }else{
		$id = "";
	$username = "";
	$password = "";
		}
	}
	function setUsername($value)
	{
		$_SESSION["user"]["name"]=$value;
		$this->username = $value;
	}
	function setPassword($value)
	{
		$this->password = $value; 
	}
	function getUsername()
	{
		return $this->username;
	}
	function getPassword()
	{
		return $this->password;
	}
	function getPasswordByName($name) {
		global $pdo;
		
		$stmt = $pdo->prepare("SELECT password FROM users WHERE username=:name");
		$result = $stmt->execute(array(':name'=>$name));
		$row = $stmt->fetch();
		if (is_array($row) && array_key_exists("password",$row)) {
			return $row["password"];
		} else {
			return NULL;
		}
	}
	
 function login($password){
  if ($password === $this->getPasswordByName($this->getUsername())) {
     $_SESSION["user"]["auth"]=TRUE;
	return TRUE;
  }
    return FALSE;
 }
  function isLoggedIn() {
    if (isset($_SESSION["user"])) {
       if (isset($_SESSION["user"]["auth"])) {
       	  return $_SESSION["user"]["auth"];
       }
    }
    return FALSE;
  }

  function logout() {
    global $session;
    $session->destroy();
  }

function saveUserData($id, $name, $password) {
		 global $pdo;
		 $stmt = $pdo->prepare("INSERT INTO users (`id`, `username`, `password`) VALUES (:id,:username,:password)");
		 $result = $stmt->execute(array(':id'=>$id, ':username'=>$name, ':password'=>$password));
		 echo "result: $result\n";
		 return $result;
	 } 
	  function getallusers()
	{
		 global $pdo;
		 $id = 1;
		 $isallusers = array();
		 $row = 1;
		 while($row != null){
		 $stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id");
		 $result = $stmt->execute(array(':id'=>$id));
		 $row = $stmt->fetch();
		 if (is_array($row) && array_key_exists("id",$row)) {
			 $isallusers[$id] = $row;
		 }
		 $id+=1;
	 }
	 return $isallusers;
}
}
	
	
