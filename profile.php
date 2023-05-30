<?php 
session_start();
include "php/db_conn.php";
include "php/post-query.php";
include "php/community-query.php";
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
        <link rel="stylesheet" href="css/profile.css" />
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
                                </div>
                                <div class="content-wrapper">
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
                <?php 
                    if (isset($_SESSION['userID']) && isset($_SESSION['username']))
                    {
                    include "php/user-query.php";
                    $userID = $_SESSION['userID'];
                    loadUser();
                    ?>
                <div class="hehe" id="hehe">
                    <div class="profile-container" id="profile-container">
                        <img class="logoID" src="resources/images/logoID.png" />
                        <div class="profile-wrapper">
                            <div class="profile-img-wrapper">
                                <img class="profile-img" src="<?php echo $_SESSION['profile-img'] ?>" />
                            </div>
                            <div class="profile-info-wrapper">
                                <p class="profile-name"><?php echo $_SESSION['username'] ?></p>
                                <p class="profile-date">Date Joined: <?php echo $_SESSION['datejoined'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bio-container" id="bio-container">
                        <div class="bio-wrapper">
                            <p class="bio-header">About me:</p>
                            <p class="bio-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
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

        
        $('#hehe').on("click", function(event) {
            $('#profile-container').toggleClass('rotate');
            $('#bio-container').toggleClass('rotate-reset');
        });

    });
    </script>

</html>