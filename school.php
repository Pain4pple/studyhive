<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/school2.css" />
        <title>StudyHive - The Ultimate Scholars' Space</title>
    </head>

    <body>
        <div id="nav-placeholder">

        </div>
        <div class="navigation-space">
        </div>
        <div class="main-content">
                <header class="block w-full">
                    <div class="carousel"
                        data-flickity='{ "imagesLoaded": true, "wrapAround": true , "autoPlay": 3000 }'>
                        <div class="gallery-cell"> <img class="banner-img"
                                src="/resources/images/banner1.png" />
                        </div>
                        <div class="gallery-cell"> <img class="banner-img"
                                src="/resources/images/banner2.png" />
                        </div>
                        <div class="gallery-cell"> <img class="banner-img"
                                src="/resources/images/banner3.png" />
                        </div>
                        <div class="gallery-cell"> <img class="banner-img"
                                src="/resources/images/banner4.png" />
                        </div>
                        <div class="gallery-cell"> <img class="banner-img"
                                src="/resources/images/banner5.png" />
                        </div>
                    </div>
                </header>
                <div class="community-section">
                    <div class="text-space">
                        <h2>Communities for Schools</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg-grid-cols-3 gap-4 button-group">
                        <div
                            class="MuiPaper-root MuiPaper-elevation MuiPaper-rounded MuiPaper-elevation0 MuiCard-root css1079caf">
                            <?php 
                            include "php/community-query.php";
                            
                            $allCommunities = getCommunities();
                            while($schoolEntity = $allCommunities->fetch_array()){
                            ?>
                            <a href="school-renderer.php?commID=<?php echo $schoolEntity['CommunityID']?>" class="no-deco-link ">
                            <button class="buttonbase-root actionarea-root css147p5fy" tabindex="0" type="button">
                                <div class="inner-border">
                                    <span
                                        style="  background: none;  border: 0px none; margin: 0px; padding: 0px; position: relative;">
                                        <img class="school-logo"
                                            src="<?php echo $schoolEntity['Logo']?>" />
                                    </span>
                                    <div class="informasyon">
                                        <h3><?php echo $schoolEntity['Name']?></h3>
                                        <p><?php echo $schoolEntity['Country']?></p>
                                    </div>
                                </div>
                            </button>
                            </a>
                            <span class="gap-span"></span>
                            <?php }?>   
                        </div>
                    </div>
                </div>
        
        </div>
        </div>
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
        });

    })
    </script>
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>;


</html>