<?php
include "db_conn.php";
$PostID = trim($_POST['PostID']);
$sql = "DELETE FROM posts WHERE PostID = '$PostID'";
mysqli_query($conn, $sql);
         reloadPostSection();

function reloadPostSection(){
    session_start();
    include "db_conn.php";
    include "post-query.php";
    include "community-query.php";
    
    $userID = $_SESSION['userID'];
    $userPosts = getUserPosts($userID);
    while($postRow = $userPosts->fetch_array()){
    ?>
                <div class="placeholder row">
                    <div class="container">
                        <div class="content-holder">
                            <div class="post-wrapper">
                                <div class="activity-header">
                                    <div>
                                        <?php 
                                                $communityInfo = getCommunityInfo($postRow['CommunityID']);
                                                ?>
                                        <img class="community-img" src="<?php echo $communityInfo['Logo'];?>"
                                            alt="Community Image">
                                    </div>
                                    <div class="post-information">
                                        <p><a href="school-renderer.php?commID=<?php echo $communityInfo['CommunityID']?>"
                                                class="link-line"><span
                                                    class="community-name">/<?php echo $communityInfo['ShortName'];?></span></a>

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
                                    <button class="delete" id="delete<?php echo $postRow['PostID'];?>">
                                    <svg id="trash" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"/> <path d="M4 7h16" /> <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /> <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /> <path d="M10 12l4 4m0 -4l-4 4" /> </svg>
                                    </button>
                                </div>
                                <div class="content-wrapper">
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
                        </div>
                    </div>

                    <br />
                </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script> 
                    $("#delete<?php echo $postRow['PostID'];?>").click(function(){
                    <?php 
                    if ($session==true){?>
                    $(".mid-section").load("php/delete-post.php",{
                        PostID:<?php echo $postRow['PostID']?>,
                    });
                    <?php }
                    else{?>
                        $('#login-modal').fadeIn().css("display", "flex");
                        $('.signup-form').hide();
                        $('.login-form').fadeIn();                                          
                    <?php }?>
                    });
                    </script>
    <?php 
    }
    ?>
    <br />
    <?php
}
?>