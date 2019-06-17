<?php
require_once("Config.php");
require_once("projects.class.php");
require_once("User.class.php");
$project = new Project();
$user = new User();
if(!empty($_POST))
{
$project->saveProject(null, $_POST["name"] , $_POST["description"], $_POST["priority"], 0, $user->getUsername());
}
header("Location: projects.php");
