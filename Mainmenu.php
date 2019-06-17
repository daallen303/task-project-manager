<?php

require_once("User.class.php");
require_once("Config.php");
$user = new User();
if($user->isLoggedIn())
{
echo('<!DOCTYPE html><html> <title>Taskr Main Menu</title>
	<title>Taskr</title>
	<head><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><link rel="stylesheet" type ="text/css" href ="./taskr.css"></head>
	<body>
	<div class="mainbody">
	<button id="logout" onclick="logout()">Log Out</button>
	<div class="jumbotron">
		<h1>Taskr</h1>
		</div>
	<button class="mainmenu" name="projects" onclick="Project()">Projects</button>
	<button class ="mainmenu" name="projects" onclick="Task()">Tasks</button>
	</body>
	</div>
	<script>
	function Project()
	{
		window.location.href = "./projects.php";
	}
	function Task()
	{
	 window.location.href ="./tasks.php";	
	}
	
	</script>
</html>');
} else header("Location: ./login.php");
