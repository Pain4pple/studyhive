<?php 
function getCommunities(){
    include "db_conn.php";
    $sql = "SELECT * FROM community";
    $allCommunities = mysqli_query($conn, $sql);
    return $allCommunities;
}

function getCommunityInfo($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM community WHERE CommunityID = '$ID' LIMIT 1";
    $communityInfo = mysqli_query($conn, $sql);
    if (mysqli_num_rows($communityInfo) === 1){
        return $communityInfo = $communityInfo->fetch_assoc();
    }
    else{
        header("Location: 404.php?error=InvalidCommunity");
    }
}
?>