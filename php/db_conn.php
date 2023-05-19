<?php
$servername= "localhost";
$username= "root";
$pass= "";

$db_name = "studyhive";

$conn = mysqli_connect($servername, $username, $pass, $db_name);

if($conn->connect_error){
    echo "Connection died";
    die('Connection Failed: '.$conn->connect_error);
}

?>