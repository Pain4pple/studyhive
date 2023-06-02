<?php 
include "db_conn.php";
include "post-query.php";
$PostID = trim($_POST['PostID']);
$Body = trim($_POST['Body']);
$Title = trim($_POST['Title']);
$stmt = $conn->prepare("UPDATE posts SET Title = ?, Body = ? WHERE PostID = ?");
$stmt->bind_param("ssi",$Title,$Body,$PostID);
         $stmt->execute();
         $stmt->close();
$postRow = getPostInfo($PostID);
reloadPost($postRow);

function reloadPost($postRow){
?>
    <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="no-deco-link">
    <div class="title"><?php echo $postRow['Title'];?></div>
    </a>

    <?php if($postRow['Media']==null){?>
    <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="no-deco-link">
    <div class="content"><?php echo $postRow['Body'];?></div>
    </a>
    <?php }else{?>
    <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="no-deco-link">
    <div class="image-container"
        style="background:url('<?php echo $postRow['Media'];?>');background-size: cover;">
    </div>
    </a>
    <?php }?>
<?php 
}
?>
