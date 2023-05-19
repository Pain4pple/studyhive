
$(document).ready(function(){
          
    $(".editor-wrapper").hide();
    $(".reply-editor-wrapper").hide();
    $("#submit-comment").hide();

      
    $("#add-comment").click(function(){
      $(".editor-wrapper").toggle("blind",200);

      $("#submit-comment").toggle();

      $(this).text(function(i, text){
        return text === "+ Add a Comment" ? "Cancel" : "+ Add a Comment";
      })
    });

    $("#cancel-reply").click(function(){
      $(".reply-editor-wrapper").toggle("blind",200);

    });

    $("#nav-placeholder").load("navbar.php");
    $("#left-placeholder").load("left-sect.html");

    });