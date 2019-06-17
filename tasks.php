<?php
require_once("task.class.php");
require_once("Config.php");
require_once("projects.class.php");
require_once("User.class.php");

$user= new User();
$task = new Task();
$tasks = array();
$alltasks =$task->getTasksbyUser($user->getUsername());
$i=0;
while($i <= count($alltasks)-1)
{
	if($alltasks[$i]["project"] == "")array_push($tasks, $alltasks[$i]);
	$i++;
}
$counter = 0;
$found = false;
if($user->isLoggedIn())
{
echo('<!DOCTYPE html><html><title>Tasks</title><head><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type ="text/css" href ="./taskr.css"></head>
<div class="mainbody">
<button id="logout" onclick="logout()">Log Out</button>
<div class="jumbotron">
    <h1>Tasks</h1></div>
<button id ="alltasks" onclick="showAll()">All Tasks</button><div id="createtaskdiv"><button id="createtaskhide" onclick="hideCreateTask()"> Hide </button><button id="createtaskshow" onclick="showCreateTask()"> Create task </button><button id="projectlink" onclick="project()">Projects</button>
<button id="aboutlink" onclick="About()">About</button>');
echo('<form id="createtask" method="POST" action="addtask.php">
name:</br><input type="text" name="name" maxlength="25"></br>
Description:</br><textarea rows="4" cols="30" name="description" maxlength="140"></textarea></br>
Priority:</br><select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br></br>
<input type="submit">
</form></div>');
echo('<body>');
//echo('<button id ="alltasks" onclick="showAll()">All Tasks</button>'); 
if($tasks==null)echo('<h1 class="none">You have no tasks</h1>');
while($counter <= count($tasks)-1)
{   
	$taskstatus = $task->getStatus($tasks[$counter]["id"]);
	$taskPriority = $task->getPriority($tasks[$counter]["id"]);{
	if($taskstatus == 0)echo('<div class="newtask">');
else if($taskstatus ==1)echo('<div class="started">');
else echo('<div class="completed">');
if($taskPriority == "Low")
{ echo('<button class="low" onclick="showDescription(');
echo($counter);
echo(')">');
}
else if($taskPriority == "Medium")
{
	 echo('<button class="medium" onclick="showDescription(');
echo($counter);
echo(')">');
}
else 
{
	echo('<button class="high" onclick="showDescription(');
echo($counter);
echo(')">');
}
echo($tasks[$counter]["name"]);
	echo('</button>');
/*echo('<button class="add" id="add'.$counter.'" onclick="showDescription(');
echo($counter);
echo(')">');
echo('+');
echo('</button>');
echo('<button class="minus" id="minus'.$counter.'"  onclick="hideDescription(');
echo($counter);
echo(')">');
echo('-');
echo('</button>');*/
echo('<div class="description" id="description'.$counter.'">');
echo('<div class="descriptiontext">');
echo($tasks[$counter]["description"]);
echo('</div><form method="POST" action="./changetaskstatus.php">
 <input type="hidden" name="id" value="'.$tasks[$counter]["id"].'">
<select name="status">
<option value="1">Started</option>
<option value="2">Completed</option></select>
<input type="submit" value="Change Status">
</form>');
echo('<button class="showedit" id="showedit'.$counter.'" onclick="showEdit('.$counter.')">Edit Task</button>');
echo('</div>');
echo('<div class = "edit" id ="edit'.$counter.'">');
echo('<button class="hideedit" id="hideedit'.$counter.'" onclick="hideEdit('.$counter.')">Hide Edit</button>');
echo('<form method = "POST" action="./updatetask.php">Name: </br> <input type="text" value="'.$tasks[$counter]["name"].'" name="name" maxlength="25"></br>Description: </br> <textarea rows="4" cols="30" " name="description" maxlength="140">'.$tasks[$counter]["description"].'</textarea></br>
<input type="hidden" name="id" value="'.$tasks[$counter]["id"].'">
<span class="editright">
Priority: </br> <select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br>
Add to project: </br>  <select name="project"><option value=""></option>');
while($row <= count($projects)-1)
{
	
echo('<option value="');
echo($projects[$row]["name"]);
echo('">');
echo($projects[$row]["name"]);
echo('</option>');
$row +=1;
}
echo('</select></br></br>
<input type="submit" value="Save Changes">
</form>
</span>');
$project = new Project();
$projects = $project->getProjectsByUsername($user->getUsername());
$row = 0;
	echo('<form class="deletetask" id="'.$counter.'" method="POST" action="deletetask.php"><input type="hidden" name ="id" value="'.$tasks[$counter]["id"].'"></br></br><input type="submit" value="Delete Task"></form>');
echo('</div>');
echo('</div> <script type="text/javascript">
document.getElementById("hideedit'.$counter.'").style.display = "none";
document.getElementById("description'.$counter.'").style.display = "none";
document.getElementById("edit'.$counter.'").style.display = "none";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
//document.getElementById("minus'.$counter.'").style.display = "none";</script>');
echo('</table>');
}
	$counter+=1;

}
echo('<div class="bottumbottons"><button id ="newtask" onclick="showNewTask()">New Tasks</button>
<button id ="started" onclick="showStarted()">Started</button>
<button id ="completed" onclick="showCompleted()">Completed</button></div></div></html>');?>
<script>
//document.getElementById("alltasks").style.display = "none";
document.getElementById("createtask").style.display = "none";
document.getElementById("createtaskhide").style.display = "none";
/*var high = document.getElementsByClassName("high");
for(i = 0; i < high.length; i++) high[i].disabled = true;
var med = document.getElementsByClassName("medium");
for(i = 0; i < med.length; i++) med[i].disabled = true;
var low = document.getElementsByClassName("low");
for(i = 0; i < low.length; i++) low[i].disabled = true;*/
function showAll()
{
document.getElementById("completed").disabled = false;
document.getElementById("started").disabled = false;
document.getElementById("newtask").disabled = false;
//document.getElementById("alltasks").style.display = "none";
//document.getElementById("alltasks").disabled = true;
var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "block";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "block";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
}
function showStarted()
{
	//document.getElementById("alltasks").style.display = "block";
document.getElementById("completed").disabled = false;
document.getElementById("started").disabled = true;
document.getElementById("newtask").disabled = false;
//document.getElementById("alltasks").disabled = false;
var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "none";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "block";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
}
function logout()
{
	document.location.href = "./dologout.php";
}
function project()
	{
		window.location.href = "./projects.php";
	}
function showNewTask()
{
	//document.getElementById("alltasks").style.display = "block";
document.getElementById("completed").disabled = false;
document.getElementById("started").disabled = false;
document.getElementById("newtask").disabled = true;
//document.getElementById("alltasks").disabled = false;
var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "block";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
}
function showCompleted()
{
	//document.getElementById("alltasks").style.display = "block";
document.getElementById("completed").disabled = true;
document.getElementById("started").disabled = false;
document.getElementById("newtask").disabled = false;
//document.getElementById("alltasks").disabled = false;
var newtask =document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "none";
var started =document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed =document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "block";
}
function showDescription(count,num)
{
	if(document.getElementById("description"+count).style.display == "block") hideDescription(count);
	else{
 document.getElementById("description"+count).style.display = "block";
 //document.getElementById("minus"+count).style.display = "inline";
 //document.getElementById("add"+count).style.display = "none";
  document.getElementById("edit"+count).style.display = "none";
document.getElementById("showedit"+count).style.display = "block";
document.getElementById("hideedit"+count).style.display = "none";
}
 
}
function hideDescription(count)
{
 document.getElementById("description"+count).style.display = "none";
 //document.getElementById("add"+count).style.display = "inline";
 //document.getElementById("minus"+count).style.display = "none";
 document.getElementById("edit"+count).style.display = "none";
document.getElementById("showedit"+count).style.display = "none";
document.getElementById("hideedit"+count).style.display = "none";
document.getElementById("edit"+count).style.display = "none";
document.getElementById("showedit"+count).style.display = "none";
document.getElementById("hideedit"+count).style.display = "none";
}
function showEdit(name)
{
document.getElementById("description"+name).style.display = "none";
document.getElementById("edit"+name).style.display = "block";
document.getElementById("showedit"+name).style.display = "none";
document.getElementById("hideedit"+name).style.display = "inline";

}
function hideEdit(name)
{
document.getElementById("edit"+name).style.display = "none";
document.getElementById("hideedit"+name).style.display = "none";
document.getElementById("showedit"+name).style.display = "inline";
document.getElementById("description"+name).style.display = "block";
}
function showCreateTask()
{
	document.getElementById("createtask").style.display = "block";
	document.getElementById("createtaskshow").style.display = "none";
	document.getElementById("createtaskhide").style.display = "block";
}
function hideCreateTask()
{
	document.getElementById("createtask").style.display = "none";
	document.getElementById("createtaskshow").style.display = "block";
	document.getElementById("createtaskhide").style.display = "none";
}
function About()
	{
		window.location.href = "./Aboutpage.html";
	}
/*<form method="POST" action="./changetaskname.php">
<input type="text" value="name">
<input type="text" value"Change name">
</form>');*/
</script>
<?php 
}else header("Location: ./login.php");
