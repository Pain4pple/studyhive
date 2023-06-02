<?php
session_start();
include "db_conn.php";

date_default_timezone_set("Asia/Manila");

 $UserID = trim($_POST['UserID']);
 $CommunityID = trim($_POST['CommunityID']);
 $Title = trim($_POST['Title']);
 $Body = trim($_POST['Body']);
 $Date = date('Y-m-d H:i:s');
 $stmt = $conn->prepare("INSERT INTO posts(UserID,CommunityID,Title,Body,Date)
         VALUES (?,?,?,?,?)");

         $stmt->bind_param("iisss",$UserID,$CommunityID,$Title,$Body,$Date);
         $stmt->execute();
         $stmt->close();
         reloadPostSection($CommunityID);

function reloadPostSection($CommunityID){ 

include "db_conn.php";
include "community-query.php";
include "user-query.php";
include "post-query.php";
include "load-button-system.php";

$session = validateUser();

if($session == true){
    $userID = $_SESSION['userID'];
    loadUser();
}
$communityInfo = getCommunityInfo($CommunityID);       
            $postResults = getCommunityPosts($CommunityID);
            while($postRow = $postResults->fetch_array()){
            ?>
                <div class="placeholder row">
                    <div class="button-system" id="button-system<?php echo $postRow['PostID']?>">
                        <?php loadButtonSystem($postRow['PostID'])?>
                    </div>
                    <div class="container">
                        <div class="content-holder">
                            <div class="post-wrapper">
                                <div class="post-header">
                                    <div>
                                        <img class="community-img" src="<?php echo $communityInfo['Logo']?>"
                                            alt="Community Image">
                                    </div>
                                    <div class="post-information">
                                        <p><a href="school-renderer.php?commID=<?php echo $communityInfo['CommunityID']?>" class="link-line"><span class="community-name">/<?php echo $communityInfo['ShortName'];?></span></a>

                                            <span class="op-info">•
                                                posted by
                                                <span class="op-name"><?php 
                                            $op = $postRow['UserID'];

                                            $sql2 = "SELECT * FROM user WHERE UserID = '$op' LIMIT 1";
                                            $OPResults = mysqli_query($conn, $sql2);
                                            $OPInfo = $OPResults->fetch_assoc();
                                            
                                            echo $OPInfo['Username'];
                                            ?></span> <?php echo getPostAge($postRow['Date']);?></span>
                                        </p>
                                        <div class="hr"></div>
                                    </div>
                                </div>

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
                            </div>
                        </div>
                        <div class="comment-component">
                            <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="comment-component">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16"
                                        fill="currentColor" class="bi bi-chat-left-fill" viewBox="0 0 16 8">
                                        <path
                                            d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                    </svg>
                                </span>
                                <span class="comment-count"><?php echo $postRow['Comments'];?> comments</span>
                            </a>
                        </div>
                    </div>
                    <br />
                </div>
                <?php 
            }
            ?>
            </div>
<?php }
?>