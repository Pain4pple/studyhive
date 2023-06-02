<?php 
session_start();
include "php/db_conn.php";
include "php/community-query.php";
include "php/user-query.php";
include "php/load-button-system.php";

$session = validateUser();

if($session == true){
    $userID = $_SESSION['userID'];
    loadUser();
}
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
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="resources/images/faviconlogo.png">
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
                        <div class="placeholder row" id="create-container">
                            <div class="create-container">
                                <div class="create-wrapper" id="create-wrapper">
                                    <div class="create-holder">
                                        <div class="flex-item">
                                        <?php if ($session == true){ ?>
                                        <img class="user-img" src="<?php echo $_SESSION['profile-img']?>"
                                                        alt="User Image">
                                        <?php } 
                                        else { ?>
                                            <img class="user-img" src="/resources/images/empty-avatar.jpg"
                                                        alt="Empty Avatar">
                                        <?php }?>
                                        </div>
                                        <div class="flex-item input">
                                        <a id="createpost" class="no-deco-link">
                                            <input type="text" name="createInput" id="createInput" value="Create a post">
                                        </a>
                                        </div>
                                        <div class="flex-item">
                                        <button class="attach-picbtn">
                                        <img class="upload-img"src="resources/images/upload-img.svg"/>
                                        </button>
                                        </div>
                                        <div class="flex-item">
                                        <button class="attach-linkbtn">
                                            <img class="attach-link"src="resources/images/link.svg"/>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-holder" id="form-holder">
                                            <input type="text" class="title-input" name="title" id="title" placeholder="Title">
                                            <div class="editor-wrapper" id="text-body" name="text-body">
                                                <div id="posteditor" class="posteditor"></div>
                                            </div>
                                            <input type=button value="Cancel" class="post-button" id="cancel">
                                            <input type=button value="Post" class="post-button" id="postButton">
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
                                        <script>
                                            var quill = new Quill("#posteditor", {
                                                theme: 'snow'
                                            });
                                        </script>
                                </div>
                            </div>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script>
                        $("#createpost").click(function(){
                            <?php
                            if ($session==true){?>
                                $("#create-wrapper").toggle();
                                $("#form-holder").toggle();
                            <?php }
                            else{?>
                                $('#login-modal').fadeIn().css("display", "flex");
                                $('.signup-form').hide();
                                $('.login-form').fadeIn();                                          
                            <?php }?>
                            });
                        
                        $("#postButton").click(function(){
                        var getText = document.getElementById("posteditor").getElementsByClassName("ql-editor");
                        <?php 
                        if ($session==true){?>
                        var text = $(getText).html();
                        var title = $("#title").val();
                        $("#post-containerrr").load("php/create-post.php",{
                            CommunityID:<?php echo $communityInfo['CommunityID']?>,
                            UserID:<?php echo $userID?>,
                            Title:title+"",
                            Body:text+"",
                        });
                         $("#create-wrapper").toggle();
                         $("#form-holder").toggle();
                        $("#title").val("");
                        $('.ql-editor').empty();
                        <?php }
                        else{?>
                            $('#login-modal').fadeIn().css("display", "flex");
                            $('.signup-form').hide();
                            $('.login-form').fadeIn();                                          
                        <?php }?>
                        });
                        </script>
                    <div id="post-containerrr">
                    <?php 
                    include "php/post-query.php";
                    
                    $postResults = getCommunityPosts($commID);
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
                    </div>
                <div class="right-section">
                    <div class="community-container">
                        <div class="community-info">
                            <p class="community-header">About community <a><span></span></a> </p>
                            <p class="community-desc"><?php echo $communityInfo['Description']?></p>
                            <p class="community-DOC">Created <?php 
                            $now = new DateTime($communityInfo['Date']);
                            $timestring = $now->format('m/d/Y');
                            echo $timestring;
                            ?>
                            </p>
                        </div>
                        <div class="profilecontent-holder">
                            
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
                                <ol>
                                    <?php 
                                    $rules = json_decode($communityInfo['Rules'], true);
                                    foreach($rules as $key=>$value){ ?>
                                    <li><a href="" class="no-deco-link"><?php echo $value ?></a></li>
                                    <hr>
                                    <?php } ?>
                                </ol>
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
        $("#form-holder").hide();
        $(function() {
            $("#nav-placeholder").load("navbar.php");
            $("#left-placeholder").load("left-sect.html");
        });

        $("#cancel").click(function(){
            $("#create-wrapper").toggle();
            $("#form-holder").toggle();
        });
    });
    </script>



</html>