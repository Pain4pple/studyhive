<?php 
session_start();

if (isset($_SESSION['userID']) && isset($_SESSION['username']))
{
    session_unset();
    session_destroy();
    header('Location: ../homepage.php');
    exit();
}
else 
{
    header('Location: ../homepage.php');
    exit();
}
?>