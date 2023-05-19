<?php 
function getRandPosts(){
 include "db_conn.php";
 $sql = "SELECT * FROM posts ORDER BY RAND() LIMIT 50";
 $postResults = mysqli_query($conn, $sql);
 return $postResults;
}

function getPostAge($date){
    $date = new DateTime($date);
    $now = new DateTime();
    $diff=date_diff($date,$now);
    if($diff->y !=0)
     echo $diff->y.' years ago';

    else if($diff->m!=0)
     echo $diff->m.' months ago';
    
    else if($diff->d!=0)
     echo $diff->d.' days ago';
    
    else if($diff->h!=0)
     echo $diff->h.' hours ago';

    else if($diff->i!=0)
     echo $diff->i.' minutes ago';
    
    else if($diff->s!=0) 
     echo $diff->s.' seconds ago';
    
    else 
     echo 'Just Now';
}

function getCommunityPosts($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM posts WHERE CommunityID = '$ID' ORDER BY Date DESC";
    $communityPosts = mysqli_query($conn, $sql);
    return $communityPosts;
}

function getPostInfo($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM posts WHERE PostID = '$ID'";
    $postInfo = mysqli_query($conn, $sql);
    return $postInfo = $postInfo->fetch_assoc();
}
?>