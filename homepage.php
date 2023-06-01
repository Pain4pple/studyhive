<?php 
session_start();
include "php/db_conn.php";
include "php/post-query.php";
include "php/community-query.php";
include "php/user-query.php";
include "php/load-button-system.php";
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="css/main.css" />
        <title>StudyHive - The Ultimate Scholars' Space</title>
    </head>

    <body>
        <div id="nav-placeholder">

        </div>
        <div class="navigation-space">
        </div>
        <div class="main-content">
            <div id="left-placeholder">
            </div>
            <div class="left-space">
            </div>
            <div class="mid-section">
                <?php                 
                $postResults = getRandPosts();
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
                                      <?php 
                                       $communityInfo = getCommunityInfo($postRow['CommunityID']);
                                       ?>
                                        <img class="community-img" src="<?php echo $communityInfo['Logo'];?>"
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
                                                ?></span> <?php echo getPostAge($postRow['Date']);?></span></p>
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
                                <?php }?>
                                <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="no-deco-link">
                                    <div class="image-container"
                                        style="background:url('<?php echo $postRow['Media'];?>');background-size: cover;">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="comment-component">
                            <a href="post.php?postID=<?php echo $postRow['PostID'];?>" class="comment-component">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="16" fill="currentColor"
                                        class="bi bi-chat-left-fill" viewBox="0 0 16 8">
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
                <br />
            </div>
            <div class="right-section">
                <div style="border-left: 2px solid #d9d9d9; height: 88vh; float: left"></div>
                <?php 
                    if (isset($_SESSION['userID']) && isset($_SESSION['username']))
                    {
                    $userID = $_SESSION['userID'];
                    loadUser();
                    ?>
                <div class="profile-container">
                    <div class="profile-holder">
                        <img class="profile-img" src="<?php echo $_SESSION['profile-img'] ?>" />
                        <div class="profile-info">
                            <p class="profile-name"><?php echo $_SESSION['username'] ?></p>
                            <p class="profile-postsnum"><?php echo $_SESSION['numberOfPost'] ?> posts</p>
                        </div>
                    </div>
                    <div class="profilecontent-holder">

                        <p class="title">Recent Posts</p>
                        <?php 
                        if ($_SESSION['numberOfPost']!=0){ 
                            $sql = "SELECT * FROM posts WHERE UserID = '$userID' ORDER BY Date DESC LIMIT 4";
                            $recentActivities = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($recentActivities) === 1){
                                while($recentrowActivities = $recentActivities->fetch_array()){
                                ?>
                        <div class="content">
                            <a href="post.php?postID=<?php echo $recentrowActivities['PostID'];?>"
                                class="no-deco-link"><?php echo $recentrowActivities['Title'];?></a>
                        </div>
                        <hr>
                        <?php
                                }
                            }
                        }
                        else{
                        ?>
                        <p class="content" style="color:#d9d9d9; margin-left:-2px;">
                            <i>No Recent Activities</i>
                        </p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php } 
                else{
                ?>
                <div class="profile-container2">
                    <div class="profile-holder">
                        <img class="profile-img2" src="resources/images/logo-2.png" />
                    </div>
                    <div class="profilecontent-holder2">
                        <p class="title">Join your peers at StudyHive</p>
                        <p class="title">and be a part of the growing hive</p>
                        <hr>
                        <div class="button-wrapper">
                            <button id="signup-btn2">Sign up!</button>
                            <svg id="sparkles" width="24px" height="24px" viewBox="-76.8 -76.8 665.60 665.60"
                                id="icons" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="0.00512">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M208,512a24.84,24.84,0,0,1-23.34-16l-39.84-103.6a16.06,16.06,0,0,0-9.19-9.19L32,343.34a25,25,0,0,1,0-46.68l103.6-39.84a16.06,16.06,0,0,0,9.19-9.19L184.66,144a25,25,0,0,1,46.68,0l39.84,103.6a16.06,16.06,0,0,0,9.19,9.19l103,39.63A25.49,25.49,0,0,1,400,320.52a24.82,24.82,0,0,1-16,22.82l-103.6,39.84a16.06,16.06,0,0,0-9.19,9.19L231.34,496A24.84,24.84,0,0,1,208,512Zm66.85-254.84h0Z" />
                                    <path
                                        d="M88,176a14.67,14.67,0,0,1-13.69-9.4L57.45,122.76a7.28,7.28,0,0,0-4.21-4.21L9.4,101.69a14.67,14.67,0,0,1,0-27.38L53.24,57.45a7.31,7.31,0,0,0,4.21-4.21L74.16,9.79A15,15,0,0,1,86.23.11,14.67,14.67,0,0,1,101.69,9.4l16.86,43.84a7.31,7.31,0,0,0,4.21,4.21L166.6,74.31a14.67,14.67,0,0,1,0,27.38l-43.84,16.86a7.28,7.28,0,0,0-4.21,4.21L101.69,166.6A14.67,14.67,0,0,1,88,176Z" />
                                    <path
                                        d="M400,256a16,16,0,0,1-14.93-10.26l-22.84-59.37a8,8,0,0,0-4.6-4.6l-59.37-22.84a16,16,0,0,1,0-29.86l59.37-22.84a8,8,0,0,0,4.6-4.6L384.9,42.68a16.45,16.45,0,0,1,13.17-10.57,16,16,0,0,1,16.86,10.15l22.84,59.37a8,8,0,0,0,4.6,4.6l59.37,22.84a16,16,0,0,1,0,29.86l-59.37,22.84a8,8,0,0,0-4.6,4.6l-22.84,59.37A16,16,0,0,1,400,256Z" />
                                </g>
                            </svg>
                            <svg id="sparkles2" width="29px" height="29px" viewBox="-76.8 -76.8 665.60 665.60"
                                id="icons" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff" stroke-width="0.00512">
                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M208,512a24.84,24.84,0,0,1-23.34-16l-39.84-103.6a16.06,16.06,0,0,0-9.19-9.19L32,343.34a25,25,0,0,1,0-46.68l103.6-39.84a16.06,16.06,0,0,0,9.19-9.19L184.66,144a25,25,0,0,1,46.68,0l39.84,103.6a16.06,16.06,0,0,0,9.19,9.19l103,39.63A25.49,25.49,0,0,1,400,320.52a24.82,24.82,0,0,1-16,22.82l-103.6,39.84a16.06,16.06,0,0,0-9.19,9.19L231.34,496A24.84,24.84,0,0,1,208,512Zm66.85-254.84h0Z" />
                                    <path
                                        d="M88,176a14.67,14.67,0,0,1-13.69-9.4L57.45,122.76a7.28,7.28,0,0,0-4.21-4.21L9.4,101.69a14.67,14.67,0,0,1,0-27.38L53.24,57.45a7.31,7.31,0,0,0,4.21-4.21L74.16,9.79A15,15,0,0,1,86.23.11,14.67,14.67,0,0,1,101.69,9.4l16.86,43.84a7.31,7.31,0,0,0,4.21,4.21L166.6,74.31a14.67,14.67,0,0,1,0,27.38l-43.84,16.86a7.28,7.28,0,0,0-4.21,4.21L101.69,166.6A14.67,14.67,0,0,1,88,176Z" />
                                    <path
                                        d="M400,256a16,16,0,0,1-14.93-10.26l-22.84-59.37a8,8,0,0,0-4.6-4.6l-59.37-22.84a16,16,0,0,1,0-29.86l59.37-22.84a8,8,0,0,0,4.6-4.6L384.9,42.68a16.45,16.45,0,0,1,13.17-10.57,16,16,0,0,1,16.86,10.15l22.84,59.37a8,8,0,0,0,4.6,4.6l59.37,22.84a16,16,0,0,1,0,29.86l-59.37,22.84a8,8,0,0,0-4.6,4.6l-22.84,59.37A16,16,0,0,1,400,256Z" />
                                </g>
                            </svg>
                        </div>
                        <p class="content" style="color:#d9d9d9; margin-left:-2px;">
                            <i>It's free!</i>
                        </p>
                    </div>
                </div>
                <?php
                }?>
            </div>
        </div>

    </body>
    <!-- jscripts-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $("#nav-placeholder").load("navbar.php");
            $("#left-placeholder").load("left-sect.html");
        });


        $('#signup-btn2').click(function() {
            $('#login-modal').fadeIn().css("display", "flex");
            $('.modal').animate({
                height: '640px'
            });
            $('.login-form').hide();
            $('.signup-form').fadeIn();
        });


    });
    </script>

</html>