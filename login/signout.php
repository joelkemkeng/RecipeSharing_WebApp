<?php
require_once (__DIR__ . '/../functions.php');

session_start();
session_unset();
session_destroy();

header('location: signin.php');
?>