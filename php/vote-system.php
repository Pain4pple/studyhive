<?php 
    function upvote($ID){
        include "db_conn.php";
        $sql = "UPDATE posts SET UpvoteCount = UpvoteCount+1 WHERE PostID = '$ID'";
        mysqli_query($conn, $sql);
        reloadUpvoteCount($ID);
    }
    function reloadUpvoteCount($ID){
        include "db_conn.php";
        $sql = "SELECT * FROM posts WHERE PostID = '$ID'";
        $postInfo = mysqli_query($conn, $sql);
        $postInfo = $postInfo->fetch_assoc();

        echo $postInfo["UpvoteCount"];
    }
?>