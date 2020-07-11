<?php
session_start();
session_destroy();
// redirect To Login
header('location:login.php');
?>