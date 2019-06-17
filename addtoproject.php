<?php
require_once("task.class.php");
require_once("Config.php");
$task = new Task();
if(!empty($_POST)) $task->setProject($_POST["id"], $_POST["username"],$_POST["project"]);
header("Location: tasks.php");
