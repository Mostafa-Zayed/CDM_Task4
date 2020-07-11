<?php
// Server Name
define('SERVER','localhost');
// Database Name
define('DATABASE','task4');
// User Name
define('USER','root');
// Connection To Server And Your Database
$connect = new PDO("mysql:host=".SERVER.";dbname=".DATABASE,USER,"");

// Ckeck if Connection To Server and Database Succefully
if(isset($connect) && !empty($connect)){
    session_start();
}else{
    die('Server Connection Error');
}
?>


