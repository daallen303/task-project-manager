<?php
require_once("Config.php");
require_once("task.class.php");
$task = new Task();
if(!empty($_POST))$task->saveTask(null,$_POST["name"],$_POST["description"], $_POST["priority"], 0, "Daniel", $_POST["poject"]);
header("Location: projects.php");

