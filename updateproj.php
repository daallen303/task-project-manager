<?php

require_once("Config.php");
require_once("projects.class.php");
require_once("task.class.php");

$task = new Task();
$project = new Project();

$project->updateProject($_POST["id"], $_POST["name"], $_POST["description"], $_POST["priority"]);
header("Location: ./projects.php");
