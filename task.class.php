<?php 
require_once("Config.php");
class Task
{

	function __construct()
	{
		$name = "some task";
		$description="some task";
		$id = null;
		$priority = "High";
		$status = 0;
		$username = "some user";
		$project ="some project";
	}
	function saveTask($id, $name, $description, $priority, $status, $username, $project){
	global $pdo;
	$stmt = $pdo->prepare("INSERT INTO tasks (`id`, `name`, `description`, `priority`,`status`, `username`, `project`) VALUES(:id,:name,:description,:priority, :status, :username, :project)");
	$result = $stmt->execute(array(':id'=>$id, ':name'=>$name, ':description'=>$description, ':priority'=>$priority, ':status'=>$status, ':username'=>$username, ':project'=>$project));
	return $result;
}
function getallTasks(){
	global $pdo;
	$id = 1;
	$isalltasks = array();
	$row = 1;
	while($row!=null)
	{
		$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id=:id");
		$result = $stmt->execute(array(':id'=>$id));
		$row =$stmt->fetch();
		if(is_array($row) && array_key_exists("id", $row)) {
			$isalltasks[$id] = $row;
		}
		$id+=1;
	}
	return $isalltasks;
}
function getTasksbyProject($name){
	global $pdo;
	$isalltasks = array();
	$low = array();
	$medium = array();
	$high = array();
	$row = 1;
	$id = 1;
	while($row!=null)
	{
		$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id=:id");
		$result = $stmt->execute(array(':id'=>$id));
		$row =$stmt->fetch();
			if($row["project"] == $name)
			{
				if ($row["priority"] == "High")array_push($high,$row);
				else if ($row["priority"] == "Medium") array_push($medium,$row);
				else array_push($low,$row);
		}
			$isalltasks = array_merge($high, $medium, $low);
			$id+=1;
	}
	return $isalltasks;
}
function getTasksbyUser($username){
	global $pdo;
	$isalltasks = array();
	$low = array();
	$medium = array();
	$high = array();
	$row = 1;
	$id = 1;
	while($row!=null)
	{
		$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id=:id");
		$result = $stmt->execute(array(':id'=>$id));
		$row =$stmt->fetch();
			if($row["username"] == $username)
			{
				if ($row["priority"] == "High")array_push($high,$row);
				else if ($row["priority"] == "Medium") array_push($medium,$row);
				else array_push($low,$row);
		}
			$isalltasks = array_merge($high, $medium, $low);
			$id+=1;
	}
	return $isalltasks;
}
function getStatus($id){
	global $pdo;
	$stmt= $pdo->prepare("SELECT status FROM tasks WHERE id=:id");
	$result = $stmt->execute(array(':id'=>$id));
	$row = $stmt->fetch();
	$status = $row["status"];
	return $status;
}
function getPriority($id){
	global $pdo;
	$stmt= $pdo->prepare("SELECT priority FROM tasks WHERE id=:id");
	$result = $stmt->execute(array(':id'=>$id));
	$row = $stmt->fetch();
	$priority = $row["priority"];
	return $priority;
}
function setStatus($id, $status)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `Status` =:status WHERE `tasks`.`id` =:id;");
	$result = $stmt->execute(array(':id'=>$id, ':status'=>$status));
	return $result;
	
}
function setPriority($id ,$priority)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `priority` =:priority WHERE `tasks`.`id` =:id;");
	$result = $stmt->execute(array(':id'=>$id, ':priority'=>$priority));
	return $result;
	
}
function setProject($id, $username, $project)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `project` =:project WHERE `tasks`.`id` =:id AND `tasks`.`username` =:username");
	$result = $stmt->execute(array(':id'=>$id, ':username'=>$username,':project'=>$project));
	return $result;
	
}
function setName($id, $username, $name)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `name` =:name WHERE `tasks`.`id` =:id AND `tasks`.`username` =:username");
	$result = $stmt->execute(array(':id'=>$id, ':username'=>$username,':name'=>$name));
	return $result;
	
}
function setDescription($id, $username, $description)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `description` =:description WHERE `tasks`.`id` =:id AND `tasks`.`username` =:username");
	$result = $stmt->execute(array(':id'=>$id, ':username'=>$username,':project'=>$description));
	return $result;
	
}
function updateTask($id, $name, $description, $priority, $project)
{
	global $pdo;
	$stmt = $pdo->prepare("UPDATE `tasks` SET `description` =:description, `name`=:name, `priority`=:priority, `project`=:project WHERE `tasks`.`id` =:id");
	$result = $stmt->execute(array(':id'=>$id, ':name'=>$name, ':description'=>$description, ':priority'=>$priority,':project'=>$project));
return $result;
}
function deletetask($id)
{
	$blank = "";
global $pdo;
$stmt = $pdo->prepare("UPDATE `tasks` SET `name` =:name, `description`=:description, `username`=:username, `project`=:project, `priority`=:priority WHERE `tasks`.`id` =:id");	
$result = $stmt->execute(array(':id'=>$id, ':name'=>$blank, ':description'=>$blank, ':project'=>$blank, ':username'=>$blank, ':project'=>$blank, ':priority'=>$blank));
return $result;
}
}
