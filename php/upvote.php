<?php 
    include "db_conn.php";

    $PostID = trim($_POST['PostID']);
    $UserID = trim($_POST['UserID']);

    $sql = "SELECT * FROM uservotes WHERE PostID = '$PostID' AND UserID = '$UserID'";
    $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 0){
            $sql = "INSERT INTO uservotes (PostID, UserID, Vote) VALUES ('$PostID','$UserID',1)";
            mysqli_query($conn, $sql);

            $sql = "UPDATE posts SET UpvoteCount = UpvoteCount+1 WHERE PostID = '$PostID'";
            mysqli_query($conn, $sql);
            reloadUpvoteCount($PostID);
        }
        else{
             $result = $result->fetch_assoc();
             if ($result['Vote'] == -1){
                $sql = "UPDATE uservotes SET Vote = 1 WHERE PostID = '$PostID' AND UserID = '$UserID'";
                mysqli_query($conn, $sql);
                
                $sql = "UPDATE posts SET UpvoteCount = UpvoteCount+2 WHERE PostID = '$PostID'";
                mysqli_query($conn, $sql);
                reloadUpvoteCount($PostID);
            }
            else if ($result['Vote'] == 0){
                $sql = "UPDATE uservotes SET Vote = 1 WHERE PostID = '$PostID' AND UserID = '$UserID'";
                mysqli_query($conn, $sql);
    
                $sql = "UPDATE posts SET UpvoteCount = UpvoteCount+1 WHERE PostID = '$PostID'";
                mysqli_query($conn, $sql);
                reloadUpvoteCount($PostID);
            }
            else if ($result['Vote'] == 1){
                $sql = "UPDATE uservotes SET Vote = 0 WHERE PostID = '$PostID' AND UserID = '$UserID'";
                mysqli_query($conn, $sql);
    
                $sql = "UPDATE posts SET UpvoteCount = UpvoteCount-1 WHERE PostID = '$PostID'";
                mysqli_query($conn, $sql);
                reloadUpvoteCount($PostID);
            }
        }
    
    function reloadUpvoteCount($ID){
        include "db_conn.php";
        include "load-button-system.php";
        include "user-query.php";
        session_start();


        loadButtonSystem($ID);
    }
?>