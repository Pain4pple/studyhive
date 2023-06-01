<?php
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
include "load-button-system.php";

$session = validateUser();

if($session == true){
    $userID = $_SESSION['userID'];
    loadUser();
}
$communityInfo = getCommunityInfo($CommunityID);
?>

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
                                        <input type=button value="Post" class="post-button" id="post">
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
                
                $("#post").click(function(){
                var getText = document.getElementById("posteditor").getElementsByClassName("ql-editor");
                <?php 
                if ($session==true){?>
                var text = $(getText).html();
                var title = $("#title").val();
                $(".post-section").load("php/create-post.php",{
                    CommunityID:<?php echo $communityInfo['CommunityID']?>,
                    UserID:<?php echo $userID?>,
                    Title:title+"",
                    Body:text+"",
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
            include "post-query.php";
            
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
                <!-- jscripts-->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script src="js/script.js"></script>
                <script type="text/javascript">
                $(document).ready(function() {
                    $("#form-holder").hide();

                    $("#cancel").click(function(){
                        $("#create-wrapper").toggle();
                        $("#form-holder").toggle();
                    });
                });
                </script>

                <?php 
            }
            ?>
<?php }
?>