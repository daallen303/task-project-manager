<?php 
require_once("Config.php");
require_once("projects.class.php");
$project = new Project();
$project->deleteProject($_POST["id"]);
header("Location: ./projects.php");
