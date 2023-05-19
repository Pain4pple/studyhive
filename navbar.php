<?php 
session_start();
include "php/db_conn.php";
?>
<head>
    <link rel="stylesheet" href="css/modal.css"/>
    <link rel="stylesheet" href="css/navbar.css"/>
</head>
<body>
    <div class="navigation-bar">
        <img src="/resources/images/logo.png" class="logo" alt="logo" />
        <nav>
          <ul class="nav_links">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="school.php">School</a></li>
            <li><a href="#">Profile</a></li>
          </ul>
        </nav>
        <a class="search" href="#">
        <?php 
        if (!isset($_SESSION['userID']) && !isset($_SESSION['username']))
        {
        ?>  
        <button id="login-show">Log-In</button>
        <?php 
        }
        else{
        ?> 
        <form action="php/logout.php" method="post">
        <button id="logout" type="submit">Log-Out</button>
        </form>
        <?php
        }
        ?> 
        </a>
    </div>

      <div id="login-modal">
        <div class="modal">
          <div class="top-form">
            <div class="close-modal">
              <img src="resources/images/close.png" />
            </div>
          </div>
          <div class="login-form">
            <h2><img src="resources/images/logo-2.png" /></h2>
            <form action="php/login.php" method="post">
              <div class="form-group">
                <input
                  type="username"
                  class="form-input"
                  id="uname"
                  name="uname"
                  placeholder="Username"
                />
                <input
                  type="password"
                  class="form-input"
                  id="password"
                  name="password"
                  placeholder="Password"
                />
              </div>
              <button type="submit" class="btn-round" id="login-btn">Log In</button>
            </form>
            <div class="signup-section">
              New to StudyHive? <a href="#a" id="unik">Sign Up</a>
            </div>
          </div>

          <div class="signup-form">
            <h2><img src="resources/images/logo-2.png" /></h2>
            <form action="php/signup.php" method="post" enctype="multipart/form-data" runat="server">
              <div class="form-group">
                <div class="file-upload">
                  <div class="wrapper">
                    <label class="button-right">
                      <input
                        type="file"
                        id="userimage"
                        name="userimage"
                        placeholder="userimage"
                      />
                    </label>
                    <img id="image-preview" src="resources/images/community image.jpg">
                  </div>
                </div>
                <input
                  type="email"
                  class="form-input email"
                  id="email"
                  name="email"
                  placeholder="Email"
                  required
                />
                <input
                  type="username"
                  class="form-input"
                  id="uname"
                  name="uname"
                  placeholder="Username"
                  required
                />
                <input
                  type="password"
                  class="form-input"
                  id="password"
                  name="password"
                  placeholder="Password"
                  required
                />
              </div>
              <button type="submit" class="btn-round" id="signup-btn">Sign Up</button>
            </form>
            <div class="signup-section">
              Already a part of the hive? <a href="#a" id="login-reshow">Log In</a>
            </div>
          </div>
        </div>
      </div>
      <script src="js/script.js"></script>
      <script>
        $(function() {

        $('#login-show').click(function() {
          $('#login-modal').fadeIn().css("display", "flex");
          $('.signup-form').hide();
          $('.login-form').fadeIn();
        });
        
        $('.close-modal').click(function() {
          $('#login-modal').fadeOut();
          $('.modal').animate({
            height:'500px'
          });
        });

        $('#login-reshow').click(function() {
          $('.signup-form').hide();
          $('.modal').animate({
            height:'500px'
          });
          $('.login-form').fadeIn();
        });


        $('#unik').click(function() {
          $('.login-form').hide();
          $('.modal').animate({
            height:'640px'
          });
          $('.signup-form').fadeIn();
        });

        imageinput = document.getElementById("userimage")
        function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#image-preview').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }
        }

          $(imageinput).change(function(){
            readURL(this);
          });

        });

      </script>
</body>
</html>