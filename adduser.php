<?php
require("Config.php");
require("User.class.php");
if(!empty($_POST))
{
$user = new User();
$user->saveuserdata(null, $_POST["name"], $_POST["password"]);
$user->setUsername($_POST["name"]);
$user->login($_POST["password"]);
header("location: ./Mainmenu.php");
}


