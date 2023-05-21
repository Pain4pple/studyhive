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

function addComment(){
    include "db_conn.php";
    $email = trim($_POST['email']);
    $stmt = $conn->prepare("insert into comments(PostID,UserID,Body,Date)
            values (?,?,?,?)");

            $stmt->bind_param("iiss",$PostID,$UserID,$Body,$Date);
            $stmt->execute();
            $stmt->close();
}

function addReply(){
    include "db_conn.php";
    $ParentCommentID = trim($_POST['ParentCommentID']);
    $UserID = trim($_POST['UserID']);
    $Body = trim($_POST['Body']);
    $ReplyingTo = trim($_POST['ReplyTo']);
    $Date = new DateTime();
    $stmt = $conn->prepare("insert into comments(ParentCommentID,UserID,Body,Date,replyingTo)
            values (?,?,?,?,?)");

            $stmt->bind_param("iisss",$ParentCommentID,$UserID,$Body,$Date,$ReplyingTo);
            $stmt->execute();
            $stmt->close();
}


function addNestedReply(){
    
}

function incrementComments($ID){
    include "db_conn.php";
    $sql = "UPDATE posts SET Comments = Comments + 1 WHERE PostID = '$ID'";
    $conn->query($sql);
}
?>