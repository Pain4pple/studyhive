<?php
  function loadUser(){
  include "db_conn.php";
  $userID = $_SESSION['userID'];
  $sql = "SELECT * FROM user WHERE UserID = '$userID'";
  $result = mysqli_query($conn, $sql);

      $row = mysqli_fetch_assoc($result);
          $_SESSION['username'] = $row['Username'];
          $_SESSION['profile-img'] = $row['ProfileImage'];
          $date = date_create($row['DateJoined']);
          $_SESSION['datejoined'] = date_format($date,"F d, Y");
  
  $sql = "SELECT * FROM posts WHERE UserID = '$userID'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1){
      $row = mysqli_fetch_assoc($result);
          $_SESSION['numberOfPost'] = mysqli_num_rows($result);
  }
  else{
    $_SESSION['numberOfPost'] = 0;
  }

  $sql = "SELECT * FROM comments WHERE UserID = '$userID'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1){
      $row = mysqli_fetch_assoc($result);
          $_SESSION['userComments'] = mysqli_num_rows($result);
  }
  else{
    $_SESSION['userComments'] = 0;
  }
}

  function getUserInfo($ID){
    include "db_conn.php";
    $sql = "SELECT * FROM user WHERE UserID = '$ID'";
    $userInfo = mysqli_query($conn, $sql);
    return $userInfo = $userInfo->fetch_assoc();
  }        

  function validateUser(){
    if (isset($_SESSION['userID']) && isset($_SESSION['sessID'])){
        return true;    
    }
    else{
        return false;
    }
  }
  
?>