<?php 
include "db_conn.php";
include "user-query.php";
$UserID = trim($_POST['UserID']);
$Bio = trim($_POST['Bio']);
$stmt = $conn->prepare("UPDATE user SET Bio = ? WHERE UserID = ?");
$stmt->bind_param("si",$Bio,$UserID);
         $stmt->execute();
         $stmt->close();
$getUserInfo = getUserInfo($UserID);
reloadBio($getUserInfo);

function reloadBio($getUserInfo){
?>
    <p class="bio-body"> <?php echo $getUserInfo['Bio'] ?></p>
<?php 
}
?>
