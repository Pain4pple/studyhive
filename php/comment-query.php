<?php 
function getComments($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM comments WHERE PostID = '$ID' ORDER BY UpvoteCount DESC LIMIT 0,10";
    $getComments = mysqli_query($conn, $sql);
    return $getComments;
}

function getCommenterInfo($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM user WHERE UserID = '$ID'";
    $getCommenterInfo = mysqli_query($conn, $sql);
    return $getCommenterInfo = $getCommenterInfo->fetch_assoc();
}

function loadReplies($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM replies WHERE ParentCommentID = '$ID' ORDER BY UpvoteCount DESC";
    $getReplies = mysqli_query($conn, $sql);
    return $getReplies;
}

function loadNestedReplies($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM nestedreplies WHERE ParentReplyID = '$ID' ORDER BY UpvoteCount DESC";
    $getNestedReplies = mysqli_query($conn, $sql);
    return $getNestedReplies;
}

function loadMoreComments($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM comments WHERE PostID = '$ID' ORDER BY UpvoteCount DESC LIMIT 10,10 ";
    $moreComments = mysqli_query($conn, $sql);
    return $moreComments;
}
?>