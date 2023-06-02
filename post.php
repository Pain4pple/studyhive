<?php 
session_start();
date_default_timezone_set("Asia/Manila");
include "php/db_conn.php";
include "php/post-query.php";
include "php/community-query.php";
include "php/user-query.php";
include "php/comment-query.php";
include "php/load-button-system.php";

$postID = isset($_GET['postID']) ? $_GET['postID'] : null;

$postRow = getPostInfo($postID);
$userInfo = getUserInfo($postRow['UserID']);
$communityInfo = getCommunityInfo($postRow['CommunityID']);
$comments = getComments($postID);
?>
<!--This html is responsible for rendering the post isolatedly and its comments-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="css/text-editor.css" />
    <link rel="stylesheet" href="css/post.css" />
    <link rel="icon" type="image/x-icon" href="resources/images/faviconlogo.png">
    <title><?php echo $postRow['Title']?></title>
</head>

<body>
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <div id="nav-placeholder">
    </div>
    <div class="navigation-space">
    </div>
    <div class="main-content">
        <div id="left-placeholder">
        </div>
        <div class="left-space">
        </div>
        <div class="mid-section ">
            <div class="post">
                <div class="wrapper">
                    <div class="post-header">
                        <div>
                            <img class="community-img" src="<?php echo $communityInfo['Logo']?>" alt="Community Image">
                        </div>
                        <div class="post-information">
                            <a href="school-renderer.php?commID=<?php echo $communityInfo['CommunityID']?>"
                                class="link-line">
                                <p class="community-name">/<?php echo $communityInfo['ShortName'];?></p>
                            </a>
                            <p class="op-info">by <span class="op-name"><?php echo $userInfo['Username']?>
                                </span><?php echo getPostAge($postRow['Date']);?></p>
                            <div class="hr"></div>
                        </div>
                    </div>
                    <div class="post-holder">
                        <?php 
                            if($postRow['Media'] != null || trim($postRow['Media']) != ""){
                            ?>
                        <p class="post-title" style="font-size:36px"><?php echo $postRow['Title']?></p>
                        <div class="post-content">
                            <?php echo $postRow['Body']?>
                            <img src="<?php echo $postRow['Media']?>" class="post-media">
                        </div>
                        <?php 
                            }
                            else{
                            ?>
                        <p class="post-title"><?php echo $postRow['Title']?></p>
                        <div class="post-content">
                            <?php echo $postRow['Body']?>
                            <img src="<?php echo $postRow['Media']?>" class="post-media">
                        </div>
                        <?php }?>
                    </div>
                    <div class="post-footer hr">
                        <div class="button-system" id="button-system<?php echo $postRow['PostID']?>">
                            <?php loadButtonSystem($postRow['PostID'])?>
                        </div>
                        <div class="comments"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" class="bi bi-chat-left-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            </svg>
                            <span class="comment-count"><?php echo $postRow['Comments'];?></span>
                        </div>
                        <div class="share">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-upload" viewBox="0 0 16 16">
                                <path
                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path
                                    d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg>
                            <span class="share-link">Share</span>
                        </div>
                    </div>
                </div>
                <div class="add-comment">
                    <div class="editor-wrapper" id="commenteditorWrapper<?php echo $postRow['PostID'] ?>">
                        <div id="commentEditor<?php echo $postRow['PostID'] ?>" class="editor"></div>
                    </div>
                    <button id="add-comment"><span>+</span> Add a Comment</button>
                    <button id="commentTo<?php echo $postRow['PostID']?>">Submit</button>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script>
                $("#commentTo<?php echo $postRow['PostID']?>").click(function() {
                    var getText = document.getElementById("commentEditor<?php echo $postRow['PostID'] ?>")
                        .getElementsByClassName("ql-editor");
                    <?php $allow = validateUser(); 
                            if ($allow==true){?>
                    var text = $(getText).html();
                    $("#commentwrapper<?php echo $postRow['PostID'] ?>").load("php/add-comment-query.php", {
                        PostID: <?php echo $postRow['PostID']?>,
                        UserID: <?php echo $_SESSION['userID']?>,
                        Body: text + "",
                    });
                    $("#commenteditorWrapper<?php echo $postRow['PostID'] ?>").toggle();
                    $("#commentTo<?php echo $postRow['PostID'] ?>").toggle();
                    $("#add-comment").text("+ Add a Comment");
                    <?php }
                            else{?>
                    $(getText).html("");
                    $('#login-modal').fadeIn().css("display", "flex");
                    $('.signup-form').hide();
                    $('.login-form').fadeIn();
                    <?php }?>
                });

                $("#add-comment").click(function() {
                    $("#commenteditorWrapper<?php echo $postRow['PostID'] ?>").toggle();
                    $("#commentTo<?php echo $postRow['PostID'] ?>").toggle();
                    $(this).text(function(i, text) {
                        return text === "+ Add a Comment" ? "Cancel" : "+ Add a Comment";
                    })
                });
                </script>
                <div class="comment-wrapper" id="commentwrapper<?php echo $postRow['PostID'] ?>">
                    <?php  
                      if (mysqli_num_rows($comments) < 1){
                      }       
                      else
                      while($commentRow = $comments->fetch_array()){
                        $commenterInfo = getCommenterInfo($commentRow['UserID']);
                      ?>
                    <div class="comment-group">
                        <div class="parent-comment">
                            <div class="comment-header">
                                <img class="commenter-img" src="<?php echo $commenterInfo['ProfileImage'];?>"
                                    alt="Community Image">
                                <div class="comment-info">
                                    <span class="commenter-name"><?php echo $commenterInfo['Username'];?></span>
                                    •
                                    <span class="comment-age"><?php echo getPostAge($commentRow['Date']);?></span>
                                    <?php 
                                    $allow = validateUser();
                                    if($allow == true){
                                        $owner = checkIfOwner($commenterInfo['UserID']);
                                    }
                                    if($owner==true){?>
                                    <a id="trash-comment<?php echo $commentRow['CommentID'] ?>"
                                        class="delete-link">Delete</a>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                                    </script>
                                    <script>
                                    $("#trash-comment<?php echo $commentRow['CommentID'] ?>").click(function() {
                                        $("#commentwrapper<?php echo $postRow['PostID'] ?>").load(
                                            "php/delete-comment-reply.php", {
                                                PostID: <?php echo $postRow['PostID'] ?>,
                                                ID: <?php echo $commentRow['CommentID']?>,
                                                Type: "comment",
                                            });
                                    });
                                    </script>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="comment-content">
                                <p><?php echo $commentRow['Body']?></p>
                            </div>
                            <button class="hide-button" id="hideportion<?php echo $commentRow['CommentID'] ?>"
                                onclick="hidePortion('thread<?php echo $commentRow['CommentID'] ?>',this)">-</button>
                            <div class="parent-comment-footer">
                                <div class="comment-reply"><span class="button-combo"><button type="button"
                                            id="replytoComment<?php echo $commentRow['CommentID'] ?>"
                                            onclick="toggleEditor('replyarea<?php echo $commentRow['CommentID'] ?>')"
                                            class="reply-link no-deco-link"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16" height="16" fill="currentColor" class="bi bi-chat-left-fill"
                                                viewBox="0 0 16 12">
                                                <path
                                                    d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                            </svg></span><span class="reply-value">Reply</span></button></div>
                            </div>
                            <div class="reply-area">
                                <div class="reply-editor-wrapper" id="replyarea<?php echo $commentRow['CommentID'] ?>">
                                    <input name="replybody" type="hidden">
                                    <div id="replyeditor<?php echo $commentRow['CommentID'] ?>" class="reply-editor">
                                    </div>
                                    <script>
                                    var replyquill = new Quill("#replyeditor<?php echo $commentRow['CommentID'] ?>", {
                                        theme: 'snow'
                                    });
                                    </script>
                                    <button id="submitreplyto<?php echo $commentRow['CommentID'] ?>">Reply</button>
                                    <button id="cancelreplyto<?php echo $commentRow['CommentID'] ?>"
                                        onclick="toggleEditor('replyarea<?php echo $commentRow['CommentID'] ?>')">Cancel</button>
                                </div>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                <script>
                                $("#submitreplyto<?php echo $commentRow['CommentID'] ?>").click(function() {
                                    var getText = document.getElementById(
                                            "replyeditor<?php echo $commentRow['CommentID'] ?>")
                                        .getElementsByClassName("ql-editor");
                                    <?php $allow = validateUser(); 
                                if ($allow==true){?>
                                    var text = $(getText).html();
                                    $("#thread<?php echo $commentRow['CommentID'] ?>").load(
                                        "php/reply-query.php", {
                                            ParentCommentID: <?php echo $commentRow['CommentID']?>,
                                            PostID: <?php echo $postRow['PostID']?>,
                                            UserID: <?php echo $_SESSION['userID']?>,
                                            Body: text + "",
                                        });
                                    <?php }
                                else{?>
                                    $(getText).html("");
                                    $('#login-modal').fadeIn().css("display", "flex");
                                    $('.signup-form').hide();
                                    $('.login-form').fadeIn();
                                    <?php }?>
                                });
                                </script>
                            </div>
                            <div class="hide-portion1" id="thread<?php echo $commentRow['CommentID'] ?>">
                                <?php 
                                $replies = loadReplies($commentRow['CommentID']);
                                if (mysqli_num_rows($replies) < 1){
                                }
                                else
                                while($replyRow = $replies->fetch_array()){
                                  $replierInfo = getCommenterInfo($replyRow['UserID']);
                                ?>
                                <div class="child-comment" id="child-comment<?php echo $commentRow['CommentID'] ?>">
                                    <div class="comment-header">
                                        <img class="commenter-img" src="<?php echo $replierInfo['ProfileImage'];?>"
                                            alt="Community Image">
                                        <div class="comment-info">
                                            <span class="commenter-name"><?php echo $replierInfo['Username'];?></span>
                                            •
                                            <span class="comment-age"><?php echo getPostAge($replyRow['Date']);?></span>
                                            <?php 
                                            $allow = validateUser();
                                            if($allow == true){
                                                $owner = checkIfOwner($replierInfo['UserID']);
                                            }
                                            if($owner==true){?>
                                            <a id="nested-trash-comment<?php echo $replyRow['ReplyID'] ?>"
                                                class="delete-link">Delete</a>
                                            <script
                                                src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                                            </script>
                                            <script>
                                            $("#nested-trash-comment<?php echo $replyRow['ReplyID'] ?>").click(
                                            function() {
                                                $("#commentwrapper<?php echo $postRow['PostID'] ?>").load(
                                                    "php/delete-comment-reply.php", {
                                                        PostID: <?php echo $postRow['PostID'] ?>,
                                                        ID: <?php echo $replyRow['ReplyID']?>,
                                                        Type: "nested",
                                                    });
                                            });
                                            </script>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <!--div class="vr" style="height:100vh;border-left:2px solid #d9d9d9"></div-->
                                    <div class="comment-content">
                                        <p><?php echo $replyRow['Body'];?></p>
                                    </div>
                                    <div class="comment-footer">
                                        <div class="comment-reply"><span class="button-combo"><button type="button"
                                                    class="reply-link no-deco-link"
                                                    id="replytoReply<?php echo $replyRow['ReplyID'] ?>"
                                                    onclick="toggleEditor('nestedreplyarea<?php echo $replyRow['ReplyID'] ?>')"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-chat-left-fill"
                                                        viewBox="0 0 16 12">
                                                        <path
                                                            d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    </svg></span><span class="reply-value">Reply</span></button>
                                        </div>
                                    </div>
                                    <div class="reply-area">
                                        <div class="reply-editor-wrapper"
                                            id="nestedreplyarea<?php echo $replyRow['ReplyID'] ?>">
                                            <div id="nestedreplyeditor<?php echo $replyRow['ReplyID'] ?>"
                                                class="reply-editor"></div>
                                            <script>
                                            var quill = new Quill(
                                                "#nestedreplyeditor<?php echo $replyRow['ReplyID'] ?>", {
                                                    theme: 'snow'
                                                });
                                            </script>
                                            <button
                                                id="submitnestedreplyto<?php echo $replyRow['ReplyID'] ?>">Reply</button>
                                            <button id="cancelnestedreplyto<?php echo $replyRow['ReplyID'] ?>"
                                                onclick="toggleEditor('nestedreplyarea<?php echo $replyRow['ReplyID'] ?>')">Cancel</button>
                                        </div>
                                    </div>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                                    </script>
                                    <script>
                                    $("#submitnestedreplyto<?php echo $replyRow['ReplyID'] ?>").click(function() {
                                        var getText = document.getElementById(
                                                "nestedreplyeditor<?php echo $replyRow['ReplyID'] ?>")
                                            .getElementsByClassName("ql-editor");
                                        <?php $allow = validateUser(); 
                                            if ($allow==true){?>
                                        var text = $(getText).html();
                                        $("#nestedreplywrapper<?php echo $replyRow['ReplyID'] ?>").load(
                                            "php/nested-reply-query.php", {
                                                ParentReplyID: <?php echo $replyRow['ReplyID']?>,
                                                PostID: <?php echo $postRow['PostID']?>,
                                                UserID: <?php echo $_SESSION['userID']?>,
                                                Body: text + "",
                                                ReplyTo: <?php echo $replierInfo['UserID']?>
                                            });
                                        <?php }
                                            else{?>
                                        $(getText).html("");
                                        $('#login-modal').fadeIn().css("display", "flex");
                                        $('.signup-form').hide();
                                        $('.login-form').fadeIn();
                                        <?php }?>
                                    });
                                    </script>
                                    <div class="second-nested-replies"
                                        id="nestedreplywrapper<?php echo $replyRow['ReplyID'] ?>">
                                        <?php 
                                      $nestedReplies = loadNestedReplies($replyRow['ReplyID']);
                                      if (mysqli_num_rows($nestedReplies) < 1){
                                      }
                                      else
                                      while($nestedReplyRow = $nestedReplies->fetch_array()){
                                        $replierInfo = getCommenterInfo($nestedReplyRow['UserID']);
                                      ?>
                                        <div class="second-child-comment">
                                            <div class="comment-header">
                                                <img class="commenter-img"
                                                    src="<?php echo $replierInfo['ProfileImage'];?>"
                                                    alt="Community Image">
                                                <div class="comment-info">
                                                    <span
                                                        class="commenter-name"><?php echo $replierInfo['Username'];?></span>
                                                    •
                                                    <span
                                                        class="comment-age"><?php echo getPostAge($nestedReplyRow['Date']);?></span>
                                                    <?php 
                                                        $allow = validateUser();
                                                        if($allow == true){
                                                            $owner = checkIfOwner($replierInfo['UserID']);
                                                        }
                                                        if($owner==true){?>
                                                    <a id="secondnest-trash-comment<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                                                        class="delete-link">Delete</a>
                                                    <script
                                                        src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                                                    </script>
                                                    <script>
                                                    $("#secondnest-trash-comment<?php echo $nestedReplyRow['NestedReplyID'] ?>")
                                                        .click(function() {
                                                            $("#commentwrapper<?php echo $postRow['PostID'] ?>")
                                                                .load("php/delete-comment-reply.php", {
                                                                    PostID: <?php echo $postRow['PostID'] ?>,
                                                                    ID: <?php echo $nestedReplyRow['NestedReplyID']?>,
                                                                    Type: "secondnest",
                                                                });
                                                        });
                                                    </script>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <!--div class="vr" style="height:100vh;border-left:2px solid #d9d9d9"></div-->
                                            <div class="comment-content">
                                                <p><?php echo $nestedReplyRow['Body'];?></p>
                                            </div>
                                            <!--div class="comment-footer">
                                              <div class="comment-vote-system">
                                                  <button id="upvote" class="vote-button upvote row">
                                                      <svg id="upvote-svg" xmlns="http://www.w3.org/2000/svg" width="20"
                                                          height="20" fill="currentColor" class="bi bi-arrow-up-circle"
                                                          viewBox="0 0 16 16">
                                                          <path fill-rule="evenodd"
                                                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                                                      </svg>
                                                  </button>
                                                  <span
                                                      class="comment-upvote-count"><?php echo $nestedReplyRow['UpvoteCount'];?></span>
                                                  <button id="downvote" class="vote-button downvote row">
                                                      <svg id="downvote-svg" xmlns="http://www.w3.org/2000/svg" width="20"
                                                          height="20" fill="currentColor" class="bi bi-arrow-down-circle"
                                                          viewBox="0 0 16 16">
                                                          <path fill-rule="evenodd"
                                                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
                                                      </svg>
                                                  </button>
                                              </div-->
                                            <div class="comment-reply"><span class="button-combo"><button type="button"
                                                        class="reply-link no-deco-link"
                                                        id="nestedreplytoReply<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                                                        onclick="toggleEditor('secondnestedreplyarea<?php echo $nestedReplyRow['NestedReplyID'] ?>')"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-chat-left-fill"
                                                            viewBox="0 0 16 12">
                                                            <path
                                                                d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                        </svg></span><span class="reply-value">Reply</span></button>
                                            </div>
                                        </div>
                                        <div class="reply-area">
                                            <div class="reply-editor-wrapper"
                                                id="secondnestedreplyarea<?php echo $nestedReplyRow['NestedReplyID'] ?>">
                                                <div id="secondnestedreplyeditor<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                                                    class="reply-editor"></div>
                                                <script>
                                                var quill3 = new Quill(
                                                    "#secondnestedreplyeditor<?php echo $nestedReplyRow['NestedReplyID'] ?>", {
                                                        theme: 'snow'
                                                    });
                                                </script>
                                                <button
                                                    id="submitsecondnestedreplyto<?php echo $nestedReplyRow['NestedReplyID'] ?>">Reply</button>
                                                <button
                                                    id="cancelsecondnestedreplyto<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                                                    onclick="toggleEditor('secondnestedreplyarea<?php echo $nestedReplyRow['NestedReplyID'] ?>')">Cancel
                                                </button>
                                                <script
                                                    src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
                                                </script>
                                                <script>
                                                $("#submitsecondnestedreplyto<?php echo $nestedReplyRow['NestedReplyID'] ?>")
                                                    .click(function() {
                                                        var getText = document.getElementById(
                                                            "secondnestedreplyeditor<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                                                            ).getElementsByClassName("ql-editor");
                                                        <?php $allow = validateUser(); 
                                                            if ($allow==true){?>
                                                        var text = $(getText).html();
                                                        $("#nestedreplywrapper<?php echo $replyRow['ReplyID'] ?>")
                                                            .load("php/nested-reply-query.php", {
                                                                ParentReplyID: <?php echo $nestedReplyRow['NestedReplyID']?>,
                                                                PostID: <?php echo $postRow['PostID']?>,
                                                                UserID: <?php echo $_SESSION['userID']?>,
                                                                Body: text + "",
                                                                ReplyTo: <?php echo $replierInfo['UserID']?>
                                                            });
                                                        <?php }
                                                            else{?>
                                                        $(getText).html("");
                                                        $('#login-modal').fadeIn().css("display", "flex");
                                                        $('.signup-form').hide();
                                                        $('.login-form').fadeIn();
                                                        <?php }?>
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                      }
                                      ?>
                                </div>
                            </div>
                            <?php 
                                }
                                ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = new Quill('#commentEditor<?php echo $postRow['PostID'] ?>', {
    theme: 'snow'
});

function callModal() {
    $('#login-modal').fadeIn().css("display", "flex");
    $('.signup-form').hide();
    $('.login-form').fadeIn();
}

function hidePortion(HidePortionID, ButtonID) {
    let hideportion = document.getElementById(HidePortionID);
    $(hideportion).toggle();
    $(ButtonID).text(function(i, text) {
        return text === "-" ? "+" : "-";
    })
}

function toggleEditor(AreaID) {
    let replyarea = document.getElementById(AreaID);
    $(replyarea).toggle();
}

$(document).ready(function() {

    $("#commenteditorWrapper<?php echo $postRow['PostID'] ?>").hide();
    $("#commentTo<?php echo $postRow['PostID'] ?>").hide();


    $("#nav-placeholder").load("navbar.php");
    $("#left-placeholder").load("left-sect.html");
});
</script>
<script src="js/jquery-ui-1.13.2.custom/jquery-ui.js"></script>
<script src="js/script.js"></script>
<script src="js/post.js"></script>

</html>