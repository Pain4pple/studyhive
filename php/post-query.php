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
     if($diff->y==1)
     echo $diff->y.' year ago';
     else
     echo $diff->y.' years ago';

    else if($diff->m!=0)
     if($diff->m==1)
     echo $diff->m.' month ago';
     else
     echo $diff->m.' months ago';
    
    else if($diff->d!=0)
     if($diff->d==1)
     echo $diff->d.' day ago';
     else
     echo $diff->d.' days ago';
    
    else if($diff->h!=0)
     if($diff->h==1)
     echo $diff->h.' hour ago';
     else
     echo $diff->h.' hours ago';

    else if($diff->i!=0)
     if($diff->i==1)
     echo $diff->i.' minute ago';
     else
     echo $diff->i.' minutes ago';
    
    else if($diff->s!=0)
     if($diff->s==1)
     echo $diff->s.' second ago';
     else 
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