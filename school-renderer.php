<?php 
session_start();
include "php/db_conn.php";
include "php/community-query.php";

$commID = isset($_GET['commID']) ? $_GET['commID'] : null;

$communityInfo = getCommunityInfo($commID);

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="css/school-renderer.css" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet" />
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
                <div class="top-section">
                    <div class="ust-banner" style="background-image:url(<?php echo $communityInfo['Header']?>);"></div>
                    <div class="profpic">
                        <img class="ust-profpic" src="<?php echo $communityInfo['Logo']?>" />
                    </div>
                    <h1><?php echo $communityInfo['Name']?></h1>
                </div>
                <div class="post-section">
                    <?php 
                include "php/post-query.php";
                
                $postResults = getCommunityPosts($commID);
                while($postRow = $postResults->fetch_array()){
                ?>
                    <div class="placeholder row">
                        <div class="button-system">
                            <button id="upvote" class="vote-button upvote">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                                </svg>
                            </button>
                            <p id="upvote-count" class="upvote-count"><?php echo $postRow['UpvoteCount']?></p>
                            <button id="downvote" class="vote-button downvote">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                                    class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
                                </svg>
                            </button>
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
                <div class="right-section">
                    <div class="community-container">
                        <div class="community-info">
                            <p class="community-header">About community <a><span></span></a> </p>
                            <p class="community-desc"><?php echo $communityInfo['Description']?></p>
                            <p class="community-DOC">Created <?php 
                            $now = new DateTime($communityInfo['Date']);
                            $timestring = $now->format('m/d/Y');
                            echo $timestring
                            ?>
                            </p>
                        </div>
                        <div class="profilecontent-holder">
                            <div class="content">
                                <a href="" class="no-deco-link" id="create-post">Create a post</a>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <div class="community-container">
                        <div class="community-rules">
                            <p class="community-header">Community Rules<a><span></span></a> </p>
                            <p class="community-desc">To keep this hive a safe place, every member should abide by these
                                rules</p>
                        </div>
                        <div class="profilecontent-holder">
                            <div class="community-links">
                                <a href="" class="no-deco-link">1. Always apply basic etiquette.</a>
                                <hr>
                                <a href="" class="no-deco-link">2. Submissions must be about UST.</a>
                                <hr>
                                <a href="" class="no-deco-link">3. Respect your fellow Thomasians.</a>
                                <hr>
                                <a href="" class="no-deco-link">4. Limit NSFW posts, please.</a>
                                <hr>
                                <a href="" class="no-deco-link">5. Use downvotes wisely!</a>
                                <hr>
                                <a href="" class="no-deco-link">6. No asking for "School Recommendations"</a>
                                <hr>
                                <a href="" class="no-deco-link">7. Spread the word!</a>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
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

    });
    </script>



</html>