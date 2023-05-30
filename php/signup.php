<?php 
session_start();
include "db_conn.php";

if (isset($_POST['email'])&&isset($_POST['uname'])&&isset($_POST['password'])){
    
    $file = $_FILES['userimage'];

    $fileName = $_FILES['userimage']['name'];
    $fileTmpName=$_FILES['userimage']['tmp_name'];
    $fileSize = $_FILES['userimage']['size'];
    $fileError = $_FILES['userimage']['error'];
    $fileType = $_FILES['userimage']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array ('jpg','png','jpeg','gif');

    if(!in_array($fileActualExt,$allowed) ) 
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";             
    }
    else
    { 
        if($fileSize < 1000000000){
        $fileNameNew = "UserImage_".uniqid('',true).".".$fileActualExt;
        $fileDestination = "../resources/images/userImages/".$fileNameNew;
        
        move_uploaded_file($fileTmpName, $fileDestination); 

        $userImage = "/resources/images/userImages/".$fileNameNew;
        }
        else{
            echo "Image is too big";
        }   

    }

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = trim($_POST['email']);
    $uname = validate($_POST['uname']);
    $pass = trim($_POST['password']);
    
    if (empty($uname)){ 
        header("Location: ../homepage.php?error=User Name is required");
        exit();
    }
    else if(empty($pass)){
        header("Location: ../homepage.php?error=Password is required");
        exit();
    }
    else if(empty($email)){
        header("Location: ../homepage.php?error=Email is required");
        exit();
    }
   
    else{
        $pass = md5($pass);
        $sql = "SELECT * FROM user WHERE username = '$uname' ";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){
            header("Location: homepage.php?error=The username is already taken");
        exit();
        }else{      
            $stmt = $conn->prepare("insert into user(Email,Username,Password,ProfileImage)
            values (?,?,?,?)");
    
            $stmt->bind_param("ssss",$email,$uname,$pass,$userImage);
            $stmt->execute();
            $stmt->close();

            $sql = "SELECT * FROM user WHERE Username = '$uname' AND Password = '$pass'";
                    $result = mysqli_query($conn, $sql);
        
                    if (mysqli_num_rows($result) === 1){
                        $row = mysqli_fetch_assoc($result);
                            $_SESSION['userID'] = $row['UserID'];
                            $_SESSION['username'] = $row['Username'];
                            $_SESSION['sessID'] = session_id();
                    }
            }
            header("Location: ../homepage.php");
            exit();
        }

}else{
    header("Location: ../homepage.php?error=not set");
    exit();
}
