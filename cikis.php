<?php 
require_once("xpanel/inc/vt.php");

unset($_SESSION["login"]);
unset($_SESSION["user"]);
setcookie("user", $_SESSION["username"], time() - 60*60*24*7);
setcookie("login", false, time() - 60*60*24*7);
session_destroy();

header("location:index.php");

?>