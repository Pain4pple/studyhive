<?php 
session_start();
include "db_conn.php";

if (!isset($_SESSION['userID']) && !isset($_SESSION['username']))
	{
        if (isset($_POST['uname']) && isset($_POST['password'])){
    
            function validate($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        
            $uname = validate($_POST['uname']);
            $pass = validate($_POST['password']);
        
            if (empty($uname)){
                header("Location: ../homepage.php?error=Username is required");
                exit();
            }else if(empty($pass)){
                header("Location: ../homepage.php?error=Password is required");
                exit();
            }else{
        
                $hashedPass = md5($pass);    
                    $sql = "SELECT * FROM user WHERE Username = '$uname' AND Password = '$hashedPass'";
                    $result = mysqli_query($conn, $sql);
        
        
                    if (mysqli_num_rows($result) === 1){
                        $row = mysqli_fetch_assoc($result);
                        if($row['Username'] == $uname && $row['Password'] == $hashedPass){
                            $_SESSION['userID'] = $row['UserID'];
                            $_SESSION['username'] = $row['Username'];                            
                            $_SESSION['sessID'] = session_id();

                            header("Location: ../homepage.php?".$_SESSION['userID']."-".$_SESSION['username']);
                            exit();
                        }else{
                            header("Location: ../homepage.php?error=Incorrect User name:".$uname." or Password:".$pass);
                            exit();
                        }
                    }else{
                        header("Location: ../homepage.php?error=NAUR");
                        exit();
                    }
                }
        
        }
    }
    else{
        header("Location: homepage.html?".$_SESSION['userID']."-".$_SESSION['username']);
        exit();
    }

?>