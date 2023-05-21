<?php
session_start();
include "db_conn.php";
include "post-query.php";
include "community-query.php";
include "user-query.php";
include "comment-query.php";
date_default_timezone_set("Asia/Manila");

 $ParentReplyID = trim($_POST['ParentReplyID']);
 $PostID = trim($_POST['PostID']);
 $UserID = trim($_POST['UserID']);
 $Body = trim($_POST['Body']);
 $ReplyingTo = trim($_POST['ReplyTo']);
 $Date = date('Y-m-d H:i:s');
 $stmt = $conn->prepare("insert into nestedreplies(ParentReplyID,UserID,Body,Date,replyingTo)
         values (?,?,?,?,?)");

         $stmt->bind_param("iissi",$ParentReplyID,$UserID,$Body,$Date,$ReplyingTo);
         $stmt->execute();
         $stmt->close();
         $getNestedReplies = loadNestedReplies($ParentReplyID);
         incrementComments($PostID);
         reloadReplies($getNestedReplies);
         
function reloadReplies($getNestedReplies)
{   
    $nestedReplies = $getNestedReplies;
    if (mysqli_num_rows($nestedReplies) < 1) {
    } else {
        while($nestedReplyRow = $nestedReplies->fetch_array()) {
            $replierInfo = getCommenterInfo($nestedReplyRow['UserID']);
            ?>
    <div class="second-child-comment">
        <div class="comment-header">
            <img class="commenter-img" src="<?php echo $replierInfo['ProfileImage'];?>"
                alt="Community Image">
            <div class="comment-info">
                <span
                    class="commenter-name"><?php echo $replierInfo['Username'];?></span>
                •
                <span
                    class="comment-age"><?php echo getPostAge($nestedReplyRow['Date']);?></span>
            </div>
        </div>
        <!--div class="vr" style="height:100vh;border-left:2px solid #d9d9d9"></div-->
        <div class="comment-content">
            <p><?php echo $nestedReplyRow['Body'];?></p>
        </div>
        <div class="comment-footer">
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
                <div class="comment-reply"><span class="button-combo"><button
                            type="button" class="reply-link no-deco-link"
                            id="nestedreplytoReply<?php echo $nestedReplyRow['NestedReplyID'] ?>"
                            onclick="toggleEditor('secondnestedreplyarea<?php echo $nestedReplyRow['NestedReplyID'] ?>')"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16"
                                height="16" fill="currentColor"
                                class="bi bi-chat-left-fill" viewBox="0 0 16 12">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            </svg></span><span class="reply-value">Reply</span></button>
                </div>
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
                    onclick="toggleEditor('secondnestedreplyarea<?php echo $nestedReplyRow['NestedReplyID'] ?>')">Cancel</button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
    $(".reply-editor-wrapper").hide();
    $(".editor-wrapper").hide();
    });
    </script>
    <?php
            }
        }
    }
    ?>