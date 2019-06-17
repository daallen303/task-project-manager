<?php
require_once("Config.php");
require_once("User.class.php");


$user = new User();

$user->setUsername($_POST["username"]);
if ($user->login($_POST["password"]))  {
header("Location: Mainmenu.php");
exit();
}else header("Location: Login.php");
