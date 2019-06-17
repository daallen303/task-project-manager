
<?php

class Project{
	
	function __construct()
	{
				$name = "some task";
		$description="some task";
		$id = null;
		$priority = "High";
		$status = 0;
		$username = "some user";
	}
	function setName($value)
	{
		$this->name = $value;
		//$_SESSION["user"]["username"]=$value;
	}
	function setDescription($value)
	{
		$this->Description = $value; 
		//$_SESSION["user"]["password"]=$value;
	}
	function getName()
	{
		return $this->$name;
	}
	function getDescription()
	{
		return $this->$description;
	}
	function saveProject($id, $name, $description, $priority, $status, $username){
	global $pdo;
	$stmt = $pdo->prepare("INSERT INTO projects (`id`, `name`, `description`, `priority`,`status`, `username`) VALUES(:id,:name,:description,:priority, :status, :username)");
	$result = $stmt->execute(array(':id'=>$id, ':name'=>$name, ':description'=>$description, ':priority'=>$priority, ':status'=>$status, ':username'=>$username));
	return $result;
}
function getallProjects(){
	global $pdo;
	$id = 1;
	$isallprojects = array();
	$row = 1;
	while($row!=null)
	{
		$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=:id");
		$result = $stmt->execute(array(':id'=>$id));
		$row =$stmt->fetch();
		if(is_array($row) && array_key_exists("id", $row)) {
			$isallprojects[$id] = $row;
		}
		$id+=1;
	}
	return $isallprojects;
}
function getProjectsbyUsername($username){
	global $pdo;
	$id = 1;
	$high = array();
	$medium = array();
	$low = array();
	$isallprojects = array();
	$row = 1;
	while($row!=null)
	{
		$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=:id");
		$result = $stmt->execute(array(':id'=>$id));
		$row =$stmt->fetch();
		if(is_array($row) && array_key_exists("id", $row)) {
			if($row["username"] == $username)
			{
				if ($row["priority"] == "High")array_push($high,$row);
				else if ($row["priority"] == "Medium") array_push($medium,$row);
				else array_push($low,$row);
		}
		}
		$id+=1;
	}
	$isallprojects = array_merge($high, $medium, $low);
	return $isallprojects;
}
function setStatus($id, $status)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `projects` SET `Status` =:status WHERE `projects`.`id` =:id;");
	$result = $stmt->execute(array(':id'=>$id, ':status'=>$status));
	return $result;
}
function setPriority($id, $priority)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `projects` SET `priority` =:priority WHERE `projects`.`id` =:id;");
	$result = $stmt->execute(array(':id'=>$id, ':priority'=>$priority));
	return $result;
}
function getStatus($id){
	global $pdo;
	$stmt= $pdo->prepare("SELECT status FROM projects WHERE id=:id");
	$result = $stmt->execute(array(':id'=>$id));
	$row = $stmt->fetch();
	$status = $row["status"];
	return $status;
}

function getPriority($id){
	global $pdo;
	$stmt= $pdo->prepare("SELECT priority FROM projects WHERE id=:id");
	$result = $stmt->execute(array(':id'=>$id));
	$row = $stmt->fetch();
	$priority = $row["priority"];
	return $priority;
}
function deleteProject($id)
{
	$blank = "";
global $pdo;
$stmt = $pdo->prepare("UPDATE `projects` SET `name` =:name, `description`=:description, `Username`=:username, `priority`=:priority WHERE `projects`.`id` =:id");	
$result = $stmt->execute(array(':id'=>$id, ':name'=>$blank, ':description'=>$blank, ':username'=>$blank, ':priority'=>$blank));
return $result;
}
function updateProject($id, $name, $description, $priority)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `projects` SET `description` =:description, `name`=:name, `priority`=:priority WHERE `projects`.`id` =:id");
	$result = $stmt->execute(array(':id'=>$id, ':name'=>$name, ':description'=>$description, ':priority'=>$priority));
return $result;
}
}
