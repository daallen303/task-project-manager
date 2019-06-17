<?php
require_once("Config.php");
require_once("projects.class.php");
require_once("User.class.php");
require_once("task.class.php");
$user = new User();

$project = new Project();
$projects = $project->getProjectsbyUsername($user->getUsername());
$projectnames = array();
for($i=0; $i<=count($projects)-1; $i++)array_push($projectnames,$projects[$i]["name"]);
$counter = 0;
$found = false;
if($user->isLoggedIn())
{
echo('<!DOCTYPE html><html><title>Projects</title><head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><link rel="stylesheet" type ="text/css" href ="./taskr.css"></head>
<div class="mainbody">
<button id="logout" onclick="logout()">Log Out</button>
<div class="jumbotron">
    <h1>Projects</h1></div>
<button id="allprojects" onclick="showAllProject()">All Projects</button><div id="createprojdiv"><button id="createprojhide" onclick="hideCreateProj()"> Hide </button><button id="createprojshow" onclick="showCreateProj()"> Create Project </button>
<button id="taskslink" onclick="task()">Tasks</button>
<button id="aboutlink" onclick="About()">About</button>');
echo('<form id="createproj" action="addproject.php" method="POST">
Name:</br><input type="text" name="name" maxlength="20"></br>
Description:</br><textarea rows="4" cols="30" name="description" maxlength="140"></textarea></br>
Priority:</br><select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br></br>
<input class="submit" type="submit" value="Add project">
</form></div><body>');
if($projects == null) echo('<h1 class= "none">You have no projects</h1>');
while($counter <= count($projects)-1)
{
	$projectstatus = $project->getStatus($projects[$counter]["id"]);
	$projectpriority = $project->getPriority($projects[$counter]["id"]);
	if($projectstatus == 0)echo('<div class="newprojectshow" id="whole'.$projects[$counter]["name"].'">');
else if($projectstatus ==1)echo('<div class="startedprojectshow" id="whole'.$projects[$counter]["name"].'">');
else echo('<div class="completedprojectshow" id="whole'.$projects[$counter]["name"].'">');
if($projectpriority == "Low")echo('<div class="projectnamelow">');
else if($projectpriority =="Medium")echo('<div class="projectnamemedium">');
else echo('<div class="projectnamehigh">');
    echo('<button class="projects" id="p'.$projects[$counter]["name"].'" onclick="showProject(');
	echo("'");
	echo($projects[$counter]["name"]);
	echo("',");
	echo($counter);
	echo(')">');
	echo($projects[$counter]["name"]);
echo('</button>');
echo('</div>');
echo('<div class="projecttasks" id="');
echo($projects[$counter]["name"]);
echo('">');
echo('<div class="descriptionp" id="descriptionp'.$counter.'">');
echo($projects[$counter]["description"]);
echo('</div>');
echo('<div class="projectstuff">');
echo('<form method="POST" action="./changeprojectstatus.php">
 <input type="hidden" name="id" value="'.$projects[$counter]["id"].'">
<select name="status">
<option value="1">Started</option>
<option value="2">Completed</option></select>
<input type="submit" value="Change Project Status">
</form>');
echo('<div class="editproj" id="editproj'.$counter.'">');
echo('<button class="hideeditproj" id="hideeditproj'.$counter.'" onclick="hideEditproj('.$counter.')">Hide Edit</button>');
echo('<form method="POST" action="./updateproj.php">
<input type="hidden" name="id" value="'.$projects[$counter]["id"].'" maxlength="20"></br>
Name:  </br><input type="text" name="name" value="'.$projects[$counter]["name"].'" maxlength="25"></br>
Description: </br><textarea rows="4" cols="30" name="description" maxlength="140" >'.$projects[$counter]["description"].'</textarea></br>
Priority: </br> <select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br></br>
<input type="submit" value="Save Changes">
</br></br>
</form>');
echo('<form class="deleteproject" id="'.$counter.'" method="POST" action="./deleteproject.php"><input type="hidden" name ="id" value="'.$projects[$counter]["id"].'"><input type="submit" value="Delete Project"></form>');
echo('</div>');
echo('<button class="showeditproj" id="showeditproj'.$counter.'" onclick="showEditproj('.$counter.')">Edit Project</button>');
echo('<span class = "newtaskprojclass">');
echo('<button class="addtaskto" id="addtaskto'.$counter.'" onclick="showaddtaskform('.$counter.')"> Add Task To Project</button>');
echo('<button class="hideaddtaskto" id="hideaddtaskto'.$counter.'" onclick="hideaddtaskform('.$counter.')"> Hide Edit Project</button>');
echo('<form method ="POST" action="./newtaskforproject.php" id="addtaskform'.$counter.'">
<input type="hidden" name="project" value="'.$projects[$counter]["name"].'">
Name:</br><input type="text" name="name" maxlength="25"></br>
Description:</br><textarea rows="4" cols="30" name="description" maxlength="140"></textarea></br>
Priority:</br><select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br></br>
<input type="submit">
</form></span></div>');
$task = new Task();
$tasks = $task->getTasksbyProject($projects[$counter]["name"]);
$count2 = 0;
if($tasks==null)echo('<h1 class="none">You have no tasks</h1>');
while($count2 <= count($tasks)-1)
{
	$taskstatus = $task->getStatus($tasks[$count2]["id"]);
	$taskPriority = $task->getPriority($tasks[$count2]["id"]);
	if($taskstatus == 0)echo('<div class="newtask">');
else if($taskstatus ==1)echo('<div class="started">');
else echo('<div class="completed">');
if($taskPriority == "Low") 
{echo('<button class="low" onclick="showDescriptiont(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">');
}
else if($taskPriority == "Medium")
{ echo('<button class="medium" onclick="showDescriptiont(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">');
}
else
{
	 echo('<button class="high" onclick="showDescriptiont(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">');
}
	echo($tasks[$count2]["name"]);
	echo('</button>');
/*echo('<button class="add" id="addt'.$tasks[$count2]["name"].$count2.'" onclick="showDescriptiont(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">');
echo('+');
echo('</button></html>');
echo('<html><button class="minus" id="minust'.$tasks[$count2]["name"].$count2.'"  onclick="hideDescriptiont(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">');
echo('-');
echo('</button>*/
echo('</html>');
echo('<div class="description" id="descriptiont'.$tasks[$count2]["name"].$count2.'"> ');
echo($tasks[$count2]["description"]);
echo('<form class="changetaskstatus" method="POST" action="./changetaskstatusproj.php">
 <input type="hidden" name="id" value="'.$tasks[$count2]["id"].'">
<select name="status">
<option value="1">Started</option>
<option value="2">Completed</option></select></br></br>
<input type="submit" value="Change Status">
</form>');
echo('<button class="showedit" id="showedit'.$tasks[$count2]["name"].$count2.'" onclick="showEdit(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">Edit Task</button>');
echo('</div>');
echo('<div id="edit'.$tasks[$count2]["name"].$count2.'">');
echo('<button class="hideedit" id="hideedit'.$tasks[$count2]["name"].$count2.'" onclick="hideEdit(');
echo("'");
echo($tasks[$count2]["name"].$count2);
echo("'");
echo(')">Hide Edit</button>');
echo('<form method = "POST" action="./updatetaskproj.php">Name:</br> <input type="text" value="'.$tasks[$count2]["name"].'" name="name" maxlength="25"></br>Description: </br> <textarea rows="4" cols="30" name="description" maxlength="140">'.$tasks[$count2]["description"].'</textarea></br>
<input type="hidden" name="id" value="'.$tasks[$count2]["id"].'">
Priority: </br> <select name="priority">
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select></br>
Project:  </br><select name="project">');
echo('<option value="');
echo($projects[$counter]["name"]);
echo('">');
echo($projects[$counter]["name"]);
echo('</option>');
$row = 0;
while($row <= count($projects)-1)
{
if($projects[$counter]["name"] != $projects[$row]["name"])
{
echo('<option value="');
echo($projects[$row]["name"]);
echo('">');
echo($projects[$row]["name"]);
echo('</option>');
}
$row +=1;
}
echo('</select></br></br>
<input type="submit" value="Save Changes">
</form>');
	echo('<form class="deletetask" id="'.$count2.'" method="POST" action="deletetaskproj.php"><input type="hidden" name ="id" value="'.$tasks[$count2]["id"].'"></br></br><input type="submit" value="Delete Task"></form>');
echo('</div> <script type="text/javascript">
document.getElementById("descriptiont'.$tasks[$count2]["name"].$count2.'").style.display = "none";
//document.getElementById("minust'.$tasks[$count2]["name"].$count2.'").style.display = "none";
document.getElementById("edit'.$tasks[$count2]["name"].$count2.'").style.display = "none";
document.getElementById("hideedit'.$tasks[$count2]["name"].$count2.'").style.display = "none";
var completed = document.getElementsByClassName("completedprojectshow");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";</script>');
echo('</table></div>');

	$count2+=1;
}
echo('</div>');
echo('<script type="text/javascript">
document.getElementById("'.$projects[$counter]["name"].'").style.display = "none";
document.getElementById("descriptionp'.$counter.'").style.display = "none";
//document.getElementById("minus'.$counter.'").style.display = "none";
document.getElementById("hideeditproj'.$counter.'").style.display = "none";
document.getElementById("editproj'.$counter.'").style.display = "none";
document.getElementById("addtaskform'.$counter.'").style.display = "none";
document.getElementById("hideaddtaskto'.$counter.'").style.display = "none";
	var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "none";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
</script>');
echo('</table>');
echo('</div>');
	$counter+=1;
}
echo('

<div class="bottumbottons">
<button id ="newtask" onclick="showNewTask()">New Tasks</button>
<button id ="started" onclick="showStarted()">Started</button> 
<button id ="completed" onclick="showCompleted()">Completed</button> 
</div>

<div class="bottumbottons">
<button id ="newproject" onclick="showNewProject()">New Projects</button>
<button id ="startedproject" onclick="showStartedProject()">Started Projects</button>
<button id ="completedproject" onclick="showCompletedProject()">Completed Projects</button> 
</div></div></body></div>');
?>
<script type="text/javascript">
document.getElementById("newtask").style.display = "none";
document.getElementById("started").style.display = "none";
document.getElementById("completed").style.display = "none";
//document.getElementById("alltasks").style.display = "none";
document.getElementById("newtask").style.display = "none";
document.getElementById("createprojhide").style.display="none";
document.getElementById("createproj").style.display="none";
//document.getElementById("alltasks").disabled = true;
/*var high = document.getElementsByClassName("high");
for(i = 0; i < high.length; i++) high[i].disabled = true;
var med = document.getElementsByClassName("medium");
for(i = 0; i < med.length; i++) med[i].disabled = true;
var low = document.getElementsByClassName("low");
for(i = 0; i < low.length; i++) low[i].disabled = true;*/
function showAllProject()
{
		var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "none";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
	document.getElementById("newtask").style.display = "none";
document.getElementById("started").style.display = "none";
document.getElementById("completed").style.display = "none";
//document.getElementById("alltasks").style.display = "none";
//document.getElementById("alltasks").disabled = true;
document.getElementById("newproject").style.display = "inline";
document.getElementById("startedproject").style.display = "inline";
document.getElementById("completedproject").style.display = "inline";
document.getElementById("completedproject").disabled = false;
document.getElementById("startedproject").disabled = false;
document.getElementById("newproject").disabled = false;
var newproject = document.getElementsByClassName("newprojectshow");
for(i = 0; i < newproject.length; i++) newproject[i].style.display = "block";
var tasks = document.getElementsByClassName("projecttasks");
for(i = 0; i < tasks.length; i++) tasks[i].style.display = "none";
var started = document.getElementsByClassName("startedprojectshow");
for(i = 0; i < started.length; i++) started[i].style.display = "block";
var completed = document.getElementsByClassName("completedprojectshow");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
var addtask = document.getElementsByClassName("newtaskprojclass");
for(i = 0; i < addtask.length; i++) addtask[i].style.display = "none";
var des = document.getElementsByClassName("descriptionp");
for(i = 0; i < des.length; i++) des[i].style.display = "none";
}
function showStartedProject()
{
document.getElementById("completedproject").disabled = false;
document.getElementById("startedproject").disabled = true;
document.getElementById("newproject").disabled = false;
var newproject = document.getElementsByClassName("newprojectshow");
for(i = 0; i < newproject.length; i++) newproject[i].style.display = "none";
var started = document.getElementsByClassName("startedprojectshow");
for(i = 0; i < started.length; i++) started[i].style.display = "block";
var completed = document.getElementsByClassName("completedprojectshow");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
}
function showNewProject()
{
document.getElementById("completedproject").disabled = false;
document.getElementById("startedproject").disabled = false;
document.getElementById("newproject").disabled = true;
var newproject = document.getElementsByClassName("newprojectshow");
for(i = 0; i < newproject.length; i++) newproject[i].style.display = "block";
var started = document.getElementsByClassName("startedprojectshow");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed = document.getElementsByClassName("completedprojectshow");
for(i = 0; i < completed.length; i++) completed[i].style.display = "none";
}
function showCompletedProject()
{
document.getElementById("completedproject").disabled = true;
document.getElementById("startedproject").disabled = false;
document.getElementById("newproject").disabled = false;
var newproject = document.getElementsByClassName("newprojectshow");
for(i = 0; i < newproject.length; i++) newproject[i].style.display = "none";
var started = document.getElementsByClassName("startedprojectshow");
for(i = 0; i < started.length; i++) started[i].style.display = "none";
var completed = document.getElementsByClassName("completedprojectshow");
for(i = 0; i < completed.length; i++) completed[i].style.display = "block";
}
function showAll()
{
document.getElementById("completed").disabled = false;
document.getElementById("started").disabled = false;
document.getElementById("newtask").disabled = false;
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
function showaddtaskform(name)
{
	document.getElementById("addtaskform"+name).style.display = "block";
	document.getElementById("hideaddtaskto"+name).style.display = "block";
	document.getElementById("addtaskto"+name).style.display = "none";
}
function hideaddtaskform(name)
{
	document.getElementById("addtaskform"+name).style.display = "none";
	document.getElementById("addtaskto"+name).style.display = "block";
	document.getElementById("hideaddtaskto"+name).style.display = "none";
}
function showNewTask()
{
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
function logout()
{
	document.location.href = "./dologout.php";
}
function task()
	{
		window.location.href = "./tasks.php";
	}
	function About()
	{
		window.location.href = "./Aboutpage.html";
	}
function showCompleted()
{
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
/*function showDescriptionp(count)
{
document.getElementById("add" + count).style.display = "none";
document.getElementById("minus" + count).style.display = "inline";
 document.getElementById("description" + count).style.display = "block";
 document.getElementById("showeditproj" + count).style.display = "block";
}

function hideDescriptionp(count)
{
document.getElementById("add" + count).style.display = "inline";
document.getElementById("minus" + count).style.display = "none";
 document.getElementById("description" + count).style.display = "none";
  document.getElementById("editproj" + count).style.display = "none";
  document.getElementById("hideeditproj" + count).style.display = "none";
}*/

function showDescriptiont(count)
{
	if(document.getElementById("descriptiont"+count).style.display == "block") hideDescriptiont(count);
	else{
//document.getElementById("addt" + count).style.display = "none";
//document.getElementById("minust" + count).style.display = "inline";
 document.getElementById("descriptiont" + count).style.display = "block";
 document.getElementById("showedit"+count).style.display = "block";
}
}

function hideDescriptiont(count)
{
//document.getElementById("addt" + count).style.display = "inline";
//document.getElementById("minust" + count).style.display = "none";
 document.getElementById("descriptiont" + count).style.display = "none";
 document.getElementById("edit"+count).style.display = "none";
document.getElementById("showedit"+count).style.display = "none";
document.getElementById("hideedit"+count).style.display = "none";
}
function showEditproj(name)
{
document.getElementById("editproj"+name).style.display = "block";
document.getElementById("showeditproj"+name).style.display = "none";
document.getElementById("hideeditproj"+name).style.display = "inline";
document.getElementById("descriptionp"+name).style.display = "none";
var change =document.getElementsByClassName("changeprojstatus");
for(i = 0; i < change.length; i++) change[i].style.display = "none";
}
function hideEditproj(name)
{
document.getElementById("editproj"+name).style.display = "none";
document.getElementById("hideeditproj"+name).style.display = "none";
document.getElementById("showeditproj"+name).style.display = "inline";
document.getElementById("descriptionp"+name).style.display = "block";
var change =document.getElementsByClassName("changeprojstatus");
for(i = 0; i < change.length; i++) change[i].style.display = "block";


}
function showEdit(name)
{
document.getElementById("edit"+name).style.display = "block";
document.getElementById("showedit"+name).style.display = "none";
document.getElementById("hideedit"+name).style.display = "inline";
document.getElementById("descriptiont"+name).style.display = "none";


}
function hideEdit(name)
{
document.getElementById("edit"+name).style.display = "none";
document.getElementById("hideedit"+name).style.display = "none";
document.getElementById("showedit"+name).style.display = "inline";
document.getElementById("descriptiont"+name).style.display = "block";

}
function showProject(name, count) 
{
	var newtask = document.getElementsByClassName("newtask");
for(i = 0; i < newtask.length; i++) newtask[i].style.display = "block";
var started = document.getElementsByClassName("started");
for(i = 0; i < started.length; i++) started[i].style.display = "block";
var completed = document.getElementsByClassName("completed");
for(i = 0; i < completed.length; i++) completed[i].style.display = "block";
	document.getElementById("newtask").style.display = "inline";
	document.getElementById("descriptionp"+count).style.display = "block";
document.getElementById("started").style.display = "inline";
document.getElementById("completed").style.display = "inline";
//document.getElementById("alltasks").style.display = "inline";
//document.getElementById("alltasks").disabled = true;
document.getElementById("started").disabled = false;
document.getElementById("completed").disabled = false;
document.getElementById("newtask").disabled = false;
document.getElementById("newproject").style.display = "none";
document.getElementById("startedproject").style.display = "none";
document.getElementById("completedproject").style.display = "none";
var addtask = document.getElementsByClassName("newtaskprojclass");
for(i = 0; i < addtask.length; i++) addtask[i].style.display = "block";
var projects = JSON.parse('<?php echo json_encode($projectnames); ?>');
for(i = 0; i <= projects.length -1; i++)
{
if(projects[i] == name){
document.getElementById(projects[i]).style.display = "block";
document.getElementById("whole" + projects[i]).style.display = "block";
}
else 
{
document.getElementById(projects[i]).style.display = "none";
document.getElementById("whole"+projects[i]).style.display = "none";
}
}
}
function hideCreateProj()
{
	document.getElementById("createprojshow").style.display="block";
	document.getElementById("createprojhide").style.display="none";
	document.getElementById("createproj").style.display="none";
}
function showCreateProj()
{
	document.getElementById("createprojshow").style.display="none";
	document.getElementById("createprojhide").style.display="block";
	document.getElementById("createproj").style.display="block";
}

</script>
<?php
}else header("Location: ./login.php");
