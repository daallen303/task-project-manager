<?php
require_once("Config.php");
require_once("projects.class.php");
$project = new project();
echo($_POST["status"]);
if(!empty($_POST))$project->setStatus($_POST["id"], $_POST["status"]);
header("Location: projects.php");


