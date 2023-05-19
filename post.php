<?php 
session_start();
include "php/db_conn.php";
include "php/post-query.php";
include "php/community-query.php";
include "php/user-query.php";

$postID = isset($_GET['postID']) ? $_GET['postID'] : null;

$postInfo = getPostInfo($postID);
$userInfo = getUserInfo($postInfo['UserID']);
$communityInfo = getCommunityInfo($postInfo['CommunityID']);
?>
<!--This html is responsible for rendering the post isolatedly and its comments-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="css/text-editor.css"/>
    <link rel="stylesheet" href="css/post.css"/>
    <title>Sample Post</title>
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
          <div class="mid-section ">
            <div class="post">
              <div class="post-header">
                  <div>
                      <img class="community-img" src="/resources/images/community image.jpg" alt="Community Image">
                  </div>
                  <div class="post-information">
                      <a href="school-renderer.php?commID=<?php echo $communityInfo['CommunityID']?>" class="link-line"><p class="community-name">/<?php echo $communityInfo['ShortName'];?></p></a>
                      <p class="op-info">by <span class="op-name"><?php echo $userInfo['Username']?> </span><?php echo getPostAge($postInfo['Date']);?></p>
                      <div class="hr"></div>
                  </div>
              </div>
              <div class="post-holder">
                  <p class="post-title"><?php echo $postInfo['Title']?></p>
                  <div class="post-content">
                    <?php echo $postInfo['Body']?>
                    <?php 
                    if($postInfo['Media'] != null || trim($postInfo['Media']) != "")
                    ?>
                    <img src="/<?php echo $postInfo['Media']?>" class="post-media">
                  </div>
              </div>
              <div class="post-footer hr">
                  <div class="vote-system">
                      <button id="upvote" class="vote-button upvote row">
                          <svg
                            id="upvote-svg"
                            xmlns="http://www.w3.org/2000/svg"
                            width="25"
                            height="25"
                            fill="currentColor"
                            class="bi bi-arrow-up-circle"
                            viewBox="0 0 16 16"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"
                            />
                          </svg>
                      </button> 
                      <span class="upvote-count">163</span>
                      <button id="downvote" class="vote-button downvote row">
                          <svg
                            id="downvote-svg"
                            xmlns="http://www.w3.org/2000/svg"
                            width="25"
                            height="25"
                            fill="currentColor"
                            class="bi bi-arrow-down-circle"
                            viewBox="0 0 16 16"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"
                            />
                          </svg>
                      </button>
                  </div>
                  <div class="comments"><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="20"
                      height="20"
                      fill="currentColor"
                      class="bi bi-chat-left-fill"
                      viewBox="0 0 16 16"
                    >
                      <path
                        d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                      />
                    </svg>
                    <span class="comment-count">42</span></div>
                  <div class="share">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                      <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                      <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                    </svg>
                    <span class="share-link">Share</span>
                  </div>
              </div>
              <div class="add-comment">
                <div class="editor-wrapper">
                  <div id="editor" class="editor"></div>
                </div>
                <button id="add-comment"><span>+</span> Add a Comment</button>
                <button id="submit-comment">Submit</button>
              </div>
              <div class="comment-group">
                  <div class="parent-comment">
                        <div class="comment-header">
                        <img class="commenter-img" src="/resources/images/community image.jpg" alt="Community Image">
                        <div class="comment-info">
                              <span class="commenter-name">abnoxy-123</span>
                              •
                              <span class="comment-age">12 hr. ago</span>
                        </div>
                        </div>
                      <div class="comment-content">
                          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris </p>
                      </div>
                      <button id="hide-portion">-</button>
                      <div class="parent-comment-footer">
                        <div class="comment-vote-system">
                          <button id="upvote" class="vote-button upvote row">
                              <svg
                                id="upvote-svg"
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="currentColor"
                                class="bi bi-arrow-up-circle"
                                viewBox="0 0 16 16"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"
                                />
                              </svg>
                          </button> 
                          <span class="comment-upvote-count">163</span>
                          <button id="downvote" class="vote-button downvote row">
                              <svg
                                id="downvote-svg"
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                fill="currentColor"
                                class="bi bi-arrow-down-circle"
                                viewBox="0 0 16 16"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"
                                />
                              </svg>
                          </button>
                      </div>
                      <div class="comment-reply"><span class="button-combo"><button type="button" id="reply-link" class="reply-link no-deco-link"><svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-chat-left-fill"
                          viewBox="0 0 16 12"
                        >
                          <path
                            d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                          />
                        </svg></span><span class="reply-value">Reply</span></button></div>
                      <div class="comment-share"><span class="button-combo"><a href="" class="no-deco-link">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 14">
                          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                          <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                        <span class="share-link">Share</span></a></span>
                      </div>
                      </div>
                      <div class="reply-area">
                        <div class="reply-editor-wrapper">
                          <div id="reply-editor" class="reply-editor"></div>
                          <button id="submit-reply">Reply</button>
                          <button id="cancel-reply">Cancel</button>
                        </div>
                      </div>
                      <div class="hide-portion1">
                        <div class="child-comment">
                          <div class="comment-header">
                            <img class="commenter-img" src="/resources/images/community image.jpg" alt="Community Image">
                            <div class="comment-info">
                                  <span class="commenter-name">abnoxy-123</span>
                                  •
                                  <span class="comment-age">12 hr. ago</span>
                            </div>
                            </div>
                          <!--div class="vr" style="height:100vh;border-left:2px solid #d9d9d9"></div-->
                          <div class="comment-content">
                              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris </p>
                          </div>
                          <div class="comment-footer">
                            <div class="comment-vote-system">
                              <button id="upvote" class="vote-button upvote row">
                                  <svg
                                    id="upvote-svg"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    fill="currentColor"
                                    class="bi bi-arrow-up-circle"
                                    viewBox="0 0 16 16"
                                  >
                                    <path
                                      fill-rule="evenodd"
                                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"
                                    />
                                  </svg>
                              </button> 
                              <span class="comment-upvote-count">163</span>
                              <button id="downvote" class="vote-button downvote row">
                                  <svg
                                    id="downvote-svg"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    fill="currentColor"
                                    class="bi bi-arrow-down-circle"
                                    viewBox="0 0 16 16"
                                  >
                                    <path
                                      fill-rule="evenodd"
                                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"
                                    />
                                  </svg>
                              </button>
                          </div>
                          <div class="comment-reply"><span class="button-combo"><a href="" class="reply-link no-deco-link"><svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="16"
                              height="16"
                              fill="currentColor"
                              class="bi bi-chat-left-fill"
                              viewBox="0 0 16 12"
                            >
                              <path
                                d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                              />
                            </svg></span><span class="reply-value">Reply</span></a></div>
                          <div class="comment-share"><span class="button-combo"><a href="" class="no-deco-link">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 14">
                              <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                              <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                            <span class="share-link">Share</span></a></span>
                          </div>
                          </div>
                          <div class="second-child-comment">
                            <div class="comment-header">
                              <img class="commenter-img" src="/resources/images/community image.jpg" alt="Community Image">
                              <div class="comment-info">
                                    <span class="commenter-name">abnoxy-123</span>
                                    •
                                    <span class="comment-age">12 hr. ago</span>
                              </div>
                              </div>
                            <!--div class="vr" style="height:100vh;border-left:2px solid #d9d9d9"></div-->
                            <div class="comment-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris </p>
                            </div>
                            <div class="comment-footer">
                              <div class="comment-vote-system">
                                <button id="upvote" class="vote-button upvote row">
                                    <svg
                                      id="upvote-svg"
                                      xmlns="http://www.w3.org/2000/svg"
                                      width="20"
                                      height="20"
                                      fill="currentColor"
                                      class="bi bi-arrow-up-circle"
                                      viewBox="0 0 16 16"
                                    >
                                      <path
                                        fill-rule="evenodd"
                                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"
                                      />
                                    </svg>
                                </button> 
                                <span class="comment-upvote-count">163</span>
                                <button id="downvote" class="vote-button downvote row">
                                    <svg
                                      id="downvote-svg"
                                      xmlns="http://www.w3.org/2000/svg"
                                      width="20"
                                      height="20"
                                      fill="currentColor"
                                      class="bi bi-arrow-down-circle"
                                      viewBox="0 0 16 16"
                                    >
                                      <path
                                        fill-rule="evenodd"
                                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"
                                      />
                                    </svg>
                                </button>
                            </div>
                            <div class="comment-reply"><span class="button-combo"><a href="" class="reply-link no-deco-link"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-chat-left-fill"
                                viewBox="0 0 16 12"
                              >
                                <path
                                  d="M2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"
                                />
                              </svg></span><span class="reply-value">Reply</span></a></div>
                            <div class="comment-share"><span class="button-combo"><a href="" class="no-deco-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 14">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                              </svg>
                              <span class="share-link">Share</span></a></span>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              
            </div>
          </div>
      </div>
</body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
      <script>
        var quill = new Quill('#editor', {
          theme: 'snow'
        });
        
        var quill = new Quill('#reply-editor', {
          theme: 'snow'
        });
        </script>
      <script src="js/jquery-ui-1.13.2.custom/jquery-ui.js"></script>
      <script src="js/script.js"></script>
      <script>
        $(document).ready(function(){

        $(".editor-wrapper").hide();
        $(".reply-editor-wrapper").hide();
        $("#submit-comment").hide();


        $("#hide-portion").click(function(){
          $(".child-comment").toggle("drop",{ direction: "up" },1000);
          $(this).text(function(i, text){
            return text === "-" ? "+" : "-";
          })
        });

        $("#add-comment").click(function(){
          $(".editor-wrapper").toggle("blind",200);

          $("#submit-comment").toggle();

          $(this).text(function(i, text){
            return text === "+ Add a Comment" ? "Cancel" : "+ Add a Comment";
          })
        });

        $("#reply-link").click(function(){
          $(".reply-editor-wrapper").toggle("blind",200);
          
        });

        $("#cancel-reply").click(function(){
          $(".reply-editor-wrapper").toggle("blind",200);

        });

        $("#nav-placeholder").load("navbar.php");
        $("#left-placeholder").load("left-sect.html");

        });
      </script>
</html>