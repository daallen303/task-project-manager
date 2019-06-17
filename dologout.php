<?php

require_once("Config.php");
require_once("User.class.php");

$user = new User();
$user->logout();
header("Location: ./Login.php");
