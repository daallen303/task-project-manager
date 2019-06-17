<?php
require_once("Config.php");
require_once("task.class.php");
$task = new Task();
$task->updateTask($_POST["id"],$_POST["name"],$_POST["description"],$_POST["priority"], $_POST["project"]);
header("Location: ./tasks.php");
