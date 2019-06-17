<?php
require_once("Config.php");
require("User.class.php");
echo('<!DOCTYPE html><html> 
	<title>Login</title>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8"> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><link rel="stylesheet" type ="text/css" href ="./taskr.css"></head>
	<body id="login">
	<h2>*Use <b>Example-user</b> as the username and <b>test1234</b> as the password or create your own account.</h2>
	<div class="mainbody">
	<div class="jumbotron">
		<h1>Task Manager</h1>
		</div>
		<title>Taskr</title>
	<head><link rel="stylesheet" type="text/css" href="./taskr.css"></head>
	<form id = "userlogin" method="POST" action="./dologin.php">
	<div>User name:</div><input type="text" name="username"></input>
	<div >Password:</div><input type="password" name="password"></input>
	<div></br><input type="submit" id = "login" value="log In"></div>
	</form>
	<form id= "createuser" method="POST" action="./adduser.php" onsubmit="return validate(this)">
	<div>User name:</div><input type="text" name="name"></input>
	<div>Password:</div><input type="password" name="password"></input>
	<div>Re-enter Password:</div><div><input type="password" name="password2"></input></div>
	</br><input value="Create Account" type="submit" id = "login" >
	</form>
	<button id= "createuserbutton" onclick="showcreateuser()">New User</button>
	<button id= "hideuser" onclick="hidecreateuser()">Back To Log In</button>
	</body>
	</div>
</html>');
   ?>
   <script>
	   document.getElementById("createuser").style.display = "none";
	   document.getElementById("userlogin").style.display = "block";
	   document.getElementById("createuserbutton").style.display = "block";
	   document.getElementById("hideuser").style.display = "none"; 
   function showcreateuser()
   {
	   document.getElementById("createuser").style.display = "block";
	   document.getElementById("userlogin").style.display = "none";
	   document.getElementById("createuserbutton").style.display = "none";
	   document.getElementById("hideuser").style.display = "block"; 
   }
   function hidecreateuser()
   {
	  document.getElementById("createuser").style.display = "none";
	   document.getElementById("userlogin").style.display = "block"; 
	   document.getElementById("createuserbutton").style.display = "block";
	   document.getElementById("hideuser").style.display = "none"; 
   }
   function validate(thisform)
   {
	   if(thisform.name.value=="")
	   {
		   alert("Please enter a username");
	   return false;
   }
   else if(thisform.password.value=="")
	   {alert("Please enter a password")
	   return false;
	    }
	   else if (thisform.password.value!=thisform.password2.value)
	   {
		   alert("The passwords you entered do not match");
		   return false;
	   }
	   else return true;
   }
   


   
   </script>
