
<?php
$servername = "localhost";
$user = "root";
$pass = "";
$dbname ="php_quiz";

// Create connection
$connection =new mysqli($servername,$user,$pass,$dbname);

if(!$connection){
    die('could not connect:'.mysql_error());
}