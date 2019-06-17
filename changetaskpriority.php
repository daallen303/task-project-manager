<?php
require_once("Config.php");
require_once("task.class.php");
$task = new Task();
$task->setPriority($_POST["id"], $_POST["priority"]);
header("Location: ./tasks.php");

