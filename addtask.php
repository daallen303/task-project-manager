<?php
require_once("Config.php");
require_once("task.class.php");
require_once("User.class.php");
$user= new User();
$task = new Task();
if(!empty($_POST))$task->saveTask(null,$_POST["name"],$_POST["description"], $_POST["priority"], 0, $user->getUsername(), "");
header("Location: tasks.php");
?>
