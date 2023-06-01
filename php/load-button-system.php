<?php 
include "db_conn.php";

function loadButtonSystem($ID){
    include "db_conn.php";
    $session = validateUser();
    if ($session==true){
        $UserID = $_SESSION['userID'];
        $sql = "SELECT * FROM uservotes WHERE PostID = '$ID' AND UserID = '$UserID'";
        $userVotes = mysqli_query($conn, $sql);
        $userVotes = $userVotes->fetch_assoc();

        $sql = "SELECT * FROM posts WHERE PostID = '$ID'";
        $postRow = mysqli_query($conn, $sql);
        $postRow = $postRow->fetch_assoc();
    ?>
            <button id="upvote<?php echo $postRow['PostID']?>" class="vote-button upvote">
                <svg id="upvote-svg<?php echo $postRow['PostID']?>" xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                    class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                </svg>
            </button>
            <p id="upvote-count<?php echo $postRow['PostID']?>" class="upvote-count"><?php echo $postRow['UpvoteCount']?></p>
            <button id="downvote<?php echo $postRow['PostID']?>" class="vote-button downvote">
                <svg id="downvote-svg<?php echo $postRow['PostID']?>" xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                    class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
                </svg>
            </button>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script>
        $("#upvote<?php echo $postRow['PostID']?>").click(function(){
        <?php
        if ($session==true){?>
            $("#button-system<?php echo $postRow['PostID']?>").load("php/upvote.php",{
                PostID:<?php echo $postRow['PostID']?>,
                UserID:<?php echo $UserID?>,
            });
        <?php }
        else{?>
            $('#login-modal').fadeIn().css("display", "flex");
            $('.signup-form').hide();
            $('.login-form').fadeIn();                                          
        <?php }?>
        });
        
        $("#downvote<?php echo $postRow['PostID']?>").click(function(){
        <?php 
        if ($session==true){?>
            $("#button-system<?php echo $postRow['PostID']?>").load("php/downvote.php",{
            PostID:<?php echo $postRow['PostID']?>,
            UserID:<?php echo $UserID?>,
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
        if($userVotes['Vote']==1)
        { 
        ?>
        <script>
            document.getElementById("upvote-svg<?php echo $postRow['PostID']?>").style.fill="#8BC34A";
            document.getElementById("downvote-svg<?php echo $postRow['PostID']?>").style.fill="#6C6C6C";
            document.getElementById("upvote-count<?php echo $postRow['PostID']?>").style.color="#8BC34A";
        </script>
        <?php }
        else if($userVotes['Vote']==-1)
        { 
        ?>
         <script>
             document.getElementById("upvote-svg<?php echo $postRow['PostID']?>").style.fill="#6C6C6C";
             document.getElementById("downvote-svg<?php echo $postRow['PostID']?>").style.fill="#bc6641";
             document.getElementById("upvote-count<?php echo $postRow['PostID']?>").style.color="#bc6641";
         </script>
        <?php }
        else
        { 
        ?>
         <script>
             document.getElementById("upvote-svg<?php echo $postRow['PostID']?>").style.fill="#6C6C6C";
             document.getElementById("downvote-svg<?php echo $postRow['PostID']?>").style.fill="#6C6C6C";
             document.getElementById("upvote-count<?php echo $postRow['PostID']?>").style.color="#6C6C6C";
         </script>
        <?php }
}
else{
    $sql = "SELECT * FROM posts WHERE PostID = '$ID'";
    $postRow = mysqli_query($conn, $sql);
    $postRow = $postRow->fetch_assoc();
    ?>
    <button id="upvote<?php echo $postRow['PostID']?>" class="vote-button upvote">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
            class="bi bi-arrow-up-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
        </svg>
    </button>
    <p id="upvote-count<?php echo $postRow['PostID']?>" class="upvote-count"><?php echo $postRow['UpvoteCount']?></p>
    <button id="downvote<?php echo $postRow['PostID']?>" class="vote-button downvote">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
            class="bi bi-arrow-down-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
        </svg>
    </button>
    <?php
}
}
?>