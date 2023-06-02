<?php 
session_start();
include "php/db_conn.php";
include "php/post-query.php";
include "php/community-query.php";
include "php/user-query.php";

$session = validateUser();
if(isset($_GET['profUser'])){
    $userPosts = getUserPosts($_GET['profUser']);
    $getUserInfo = getUserInfo($_GET['profUser'])
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="css/profile.css" />
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
            <?php                 
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
                                        <?php $owner = checkIfOwner($_GET['profUser']);
                                        if ($owner == true){
                                    ?>
                                        <button class="btn-group" id="delete<?php echo $postRow['PostID'];?>">
                                            <svg id="trash" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 448 512">
                                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg>
                                        </button>
                                        <button class="btn-group" id="pencil<?php echo $postRow['PostID'];?>">
                                            <svg id="pencil" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                viewBox="0 0 512 512">
                                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                <path
                                                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z" />
                                            </svg>
                                        </button>
                                        <?php }
                                    ?>
                                    </p>
                                    <div class="hr"></div>
                                </div>
                            </div>
                            <div class="content-wrapper" id="display<?php echo $postRow['PostID'];?>">
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
                            <div class="content-wrapper post-updator" id="edit<?php echo $postRow['PostID'];?>">
                                <input type="text" class="title-input" name="title"
                                    id="title<?php echo $postRow['PostID'] ?>" value="<?php echo $postRow['Title']?>">
                                <div class="editor-wrapper" id="text-body" name="text-body">
                                    <div id="posteditor<?php echo $postRow['PostID'] ?>" class="posteditor">
                                        <?php echo $postRow['Body'] ?>
                                    </div>
                                </div>
                                <input type=button value="Cancel" class="post-button"
                                    id="cancel<?php echo $postRow['PostID'] ?>">
                                <input type=button value="Done" class="post-button"
                                    id="postButton<?php echo $postRow['PostID'] ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <br />
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
            $(document).ready(function() {
                $('#edit<?php echo $postRow['PostID'];?>').toggle();
            });

            var editPost = new Quill("#posteditor<?php echo $postRow['PostID'] ?>", {
                theme: 'snow'
            });

            $("#delete<?php echo $postRow['PostID'];?>").click(function() {
                <?php 
                if ($session==true){?>
                $(".mid-section").load("php/delete-post.php", {
                    PostID: <?php echo $postRow['PostID']?>,
                });
                <?php }
                else{?>
                $('#login-modal').fadeIn().css("display", "flex");
                $('.signup-form').hide();
                $('.login-form').fadeIn();
                <?php }?>
            });

            $("#pencil<?php echo $postRow['PostID'];?>").click(function() {
                <?php 
                if ($session==true){?>
                $('#display<?php echo $postRow['PostID'];?>').toggle();
                $('#edit<?php echo $postRow['PostID'];?>').toggle();
                <?php }
                else{?>
                $('#login-modal').fadeIn().css("display", "flex");
                $('.signup-form').hide();
                $('.login-form').fadeIn();
                <?php }?>
            });

            $("#cancel<?php echo $postRow['PostID'] ?>").click(function() {
                <?php 
                if ($session==true){?>
                $('#display<?php echo $postRow['PostID'];?>').toggle();
                $('#edit<?php echo $postRow['PostID'];?>').toggle();
                <?php }?>
            });

            $("#postButton<?php echo $postRow['PostID'] ?>").click(function() {
                var getText = document.getElementById("posteditor<?php echo $postRow['PostID'] ?>")
                    .getElementsByClassName("ql-editor");
                <?php 
                    if ($session==true){?>
                var text = $(getText).html();
                var title = $("#title<?php echo $postRow['PostID'] ?>").val();

                $('#edit<?php echo $postRow['PostID'];?>').toggle();
                $("#display<?php echo $postRow['PostID'];?>").load("php/edit-post.php", {
                    PostID: <?php echo $postRow['PostID'];?>,
                    Title: title + "",
                    Body: text + "",
                });
                $('#display<?php echo $postRow['PostID'];?>').toggle();
                <?php }?>
            });
            </script>
            <?php 
                }
                ?>
            <br />
        </div>
        <div class="right-section">
            <div class="hehe" id="hehe">
                <div class="profile-container" id="profile-container">
                    <img class="logoID" src="resources/images/logoID.png" />
                    <div class="profile-wrapper">
                        <div class="profile-img-wrapper">
                            <img class="profile-img" src="<?php echo $getUserInfo['ProfileImage'] ?>" />
                        </div>
                        <div class="profile-info-wrapper">
                            <p class="profile-name"><?php echo $getUserInfo['Username'] ?></p>
                            <p class="profile-date">Date Joined: <?php 
                                 $date = date_create($getUserInfo['DateJoined']);
                                 $date = date_format($date,"F d, Y");
                                echo $date ?></p>
                        </div>
                    </div>
                </div>
                <div class="bio-container" id="bio-container">
                    <div class="bio-wrapper" id="bio-display">
                        <p class="bio-header">About me:
                            <a id="bioeditbtn">
                                Edit
                            </a>
                        </p>
                        <div id="bio-body"><p class="bio-body"> <?php echo $getUserInfo['Bio'] ?></p></div>
                        <input type=button value="Back" class="back-button"
                            id="back-button">
                    </div>

                    <div class="bio-wrapper" id="bio-form">
                        <p class="bio-header">About me:</p>
                        <div id="bio-editor" class="bioeditor"><?php echo $getUserInfo['Bio'] ?></div>
                        <input type=button value="Done" class="done-button"
                            id="bio-done<?php echo $getUserInfo['UserID'] ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<!-- jscripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(function() {
        $("#nav-placeholder").load("navbar.php");
        $("#left-placeholder").load("left-sect.html");
        $("#bio-form").hide();
    });


    $('#signup-btn2').click(function() {
        $('#login-modal').fadeIn().css("display", "flex");
        $('.modal').animate({
            height: '640px'
        });
        $('.login-form').hide();
        $('.signup-form').fadeIn();
    });


    $('#profile-container').on("click", function(event) {
        $('#profile-container').toggleClass('rotate');
        $('#bio-container').toggleClass('rotate-reset');
    });

    $('#back-button').on("click", function(event) {
        $('#profile-container').toggleClass('rotate');
        $('#bio-container').toggleClass('rotate-reset');
    });

    var bioEditor = new Quill("#bio-editor", {
        theme: 'snow'
    });

    $("#bioeditbtn").click(function() {
        <?php 
    if ($session==true){?>
        $('#bio-display').toggle();
        $('#bio-form').toggle();
        <?php }
    else{?>
        $('#login-modal').fadeIn().css("display", "flex");
        $('.signup-form').hide();
        $('.login-form').fadeIn();
        <?php }?>
    });

    $("#bio-done<?php echo $getUserInfo['UserID'] ?>").click(function() {
        var getText = document.getElementById("bio-editor").getElementsByClassName("ql-editor");
        <?php 
        if ($session==true){?>
        var bio = $(getText).html();

        $('#bio-form').toggle();
        $("#bio-body").load("php/edit-bio.php", {
            UserID: <?php echo $getUserInfo['UserID'];?>,
            Bio: bio + "",
        });
        $('#bio-display').toggle();
        <?php }?>
    });


});
</script>

</html>
<?php 
}
?>