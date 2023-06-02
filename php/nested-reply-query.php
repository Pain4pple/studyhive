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