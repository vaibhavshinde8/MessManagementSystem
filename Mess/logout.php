<?php
session_start();
//unset sesion veraible
$_SESSION = array();

session_destroy();
header("Location: index.html");
exit;
?>
