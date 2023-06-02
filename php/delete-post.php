<?php
session_start();
include "db_conn.php";
$PostID = trim($_POST['PostID']);
$ProfUser = trim($_POST['ProfUser']);
$sql = "DELETE FROM posts WHERE PostID = '$PostID'";
mysqli_query($conn, $sql);
?>