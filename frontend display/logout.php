<?php
session_start(); // Start session

session_destroy();

header('Location: login.php');
exit;
?>