<?php
require_once("Config.php");
require_once("projects.class.php");
$project = new Project();
$project->setPriority($_POST["id"], $_POST["priority"]);
header("Location: ./projects.php");


