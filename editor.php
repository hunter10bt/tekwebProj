<?php
  session_start();
  
  include "connectdb.php";
  if(!isset($_GET["id"])){
    header("location: index.php");
  }
  else{
    $chapterID = $_GET["id"];
    $query = "SELECT author, storyID FROM story WHERE storyID = ANY(SELECT storyID FROM chapter WHERE chapterID = $chapterID)";
    $authorResult = mysqli_query($con, $query);
    if($authorResult){
      $row = mysqli_fetch_array($authorResult);
      $authorID = $row[0];
      $storyID = $row[1];
      $isEditor = false;

      if(isset($_SESSION["uname"]) and $_SESSION["uname"] == $authorID){
        $isEditor = true;
      }
      if(!$isEditor){
        header("location: index.php");
      }
    }
    else {
      header("location: index.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<script src="jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editor - ReadHere</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light navbar-fixed-top" id="navbar">
    <a class="navbar-brand" href="index.php">ReadHere</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <?php
          if(!isset($_SESSION["uname"])){
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signin.php?prevPage=reader.php?id=$_GET[id]'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=reader.php?id={$_GET["id"]}'>Sign Up</a>";
            echo '</li>';
          }
          else {

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=reader.php?id={$_GET["id"]}'>Sign Out</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='#'>$_SESSION[uname]</a>";
            echo '</li>';
          }
        ?>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid" id="container">
    <div class="row">
      <div class="col-xl-2" id="sidebar">
        <div class="list-group">
          <button type="button" class="list-group-item list-group-item-action list-group-item-success" id="saveButton">Save</button>
          <button type="button" class="list-group-item list-group-item-action list-group-item-danger" id="loadChapterButton">Reload from Server</button>
          <a name="return" id="exit" class="list-group-item list-group-item-action list-group-item-primary" href="story.php?id=<?php echo $storyID; ?>" role="button">Back to Story Page</a>
        </div>
        <div id="changeCheck"></div>
      </div>
      <div class="col-xl-10" contenteditable="true" id="result">
        
      </div>
    </div>
  </div>
</body>
<script>
  var change = false;
  onChange();

  function onChange(){
    if (change) {
      $("#changeCheck").html('Unsaved changes. Click save button to save.');
    } else {
      $("#changeCheck").html('Changes are saved.');
    }
  }

  //Membuat mutation observer 
  // var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;
  // var list = document.querySelector('#result');
  // var observer = new MutationObserver(
  //   function(mutations){
  //     change = true;
  //     onChange();
  //   }
  // );
  // var config = { attributes: true, childList: true, characterData: true };
  // observer.observe(list, config);

  function loadChapter(){
    //Loads from AJAX
    var chapterID = <?php echo $_GET["id"]; ?>;
    
    $.ajax(
      {
        url: "loadChapter.php",
        type: "post",
        data: {
          loadChapter: true,
          chapterID: chapterID,
        },
        success: function (result) {
          $("#result").html(result);
          change = false;
          onChange();
        }
      }
    );
  }

  function saveChapter(){
    var chapterID = <?php echo $_GET["id"]; ?>;
    var paragraphs = [];

    $("#result").children().each(
      function(){
        paragraphs.push($(this).text());
      }
    );

    alert(paragraphs);

    $.ajax(
      {
        url: "saveChapter.php",
        type: "post",
        data: {
          paragraphs: paragraphs,
          saveChapter: true,
          chapterID: chapterID
        },
        success: function(){
          change = false;
          onChange();
          alert("Changes successfully saved.")
        }
      }
    );
  }

  $(document).ready(
    function() {
      loadChapter();

      $("#saveButton").click(
        function(){
          saveChapter();
        }
      );

      $("#loadChapterButton").click(
        function(){
          loadChapter();
        }
      );

      $("body").delegate("#result",
        "DOMSubtreeModified",
        function(){
          change = true;
          onChange();
        }
      );

      change = false;
      onChange();
    }
  );
</script>
</html>