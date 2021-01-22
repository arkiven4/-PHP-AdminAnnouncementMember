<?php
include "./assets/php/theme.php";
include "./assets/php/functions.php";

session_start();
$_SESSION = [];
session_unset();
session_destroy();

header("Location: ". $GLOBALS['rootlink'] ."/login.php");
exit;