<?php 
require_once("Config.php");
require_once("task.class.php");
$task = new Task();
$task->deleteTask($_POST["id"]);
header("Location: ./tasks.php");
