<?php
  session_start();
  include "connectdb.php";
  if(!isset($_GET['id'])){
    header("location: index.php");
  }
  else {
    $storyID = $_GET["id"];
    $info = mysqli_query($con, "SELECT `title`, `summary`, `author` FROM story WHERE storyID='$storyID' AND readable=1");

    $row = mysqli_fetch_array($info);
    if($row == null){
      header("location: index.php");
    }
    else {    
      $name = $row[0];
      $summary = $row[1];
      $authorID = $row[2];
    }

    if($authorID == $_SESSION["uname"]){
      $isAuthor = true;
    }
    else {
      $isAuthor = false;
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
  <title>Story - ReadHere</title>
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
            echo '<a class="nav-link" href="signin.php?prevPage=index.php">Sign In</a>';
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="signup.php?prevPage=index.php">Sign Up</a>';
            echo '</li>';
          }
          else {

            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="signout.php?prevPage=index.php">Sign Out</a>';
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo '<a class="nav-link" href="#">New Story</a>';
            echo '</li>';
          }
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
          <div class="dropdown-menu" aria-labelledby="dropdownId">
            <a class="dropdown-item" href="#">Action 1</a>
            <a class="dropdown-item" href="#">Action 2</a>
          </div>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid"id="container">
    <div class="row">
      <div class="col-xl-10">
        <div class="row">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-about" role="tabpanel" aria-labelledby="list-about-list">
              <?php
                echo "<h2>$name</h2>";
                echo "<p>$summary</p>";
                echo "<p>By $authorID</p>";
              ?>
            </div>
            <div class="tab-pane fade" id="list-chapters" role="tabpanel" aria-labelledby="list-chapters-list">
              <h2>List of Chapters</h2>
              <div class="list-group" id="list-group-chapters">
              </div>
            </div>
            <div class="tab-pane fade" id="list-discussions" role="tabpanel" aria-labelledby="list-discussions-list">
              <h2>List of Discussions</h2>
              <div class="list-group" id="discussion-list">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-about-list" data-toggle="list" href="#list-about" role="tab" aria-controls="about">About this Story</a>
          <?php
            echo "<a class='list-group-item list-group-item-action' id='list-chapters-list' data-toggle='list' href='#list-chapters' role='tab' aria-controls='chapters' storyID='$storyID'>List of Chapters</a>";
            echo "<a class='list-group-item list-group-item-action' id='list-discussions-list' data-toggle='list' href='#list-discussions' role='tab' aria-controls='discussions' storyID='$storyID'> Discussions </a>";
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  $(
    function(){
      $("#list-chapters-list").click(
        function(){
          var s_id = $(this).attr("storyID");
          $.ajax(
            {
              url: "loadChapterList.php",
              type: "POST",
              async: true,
              data:{
                storyID: s_id,
                loadChapters: true,
              },
              success: function(result){
                $("#list-group-chapters").html(result);
              }
            }
          );
        }
      );

      $("list-discussions-list").click(
        function(){
          var s_id = $(this).attr("storyID");
          $.ajax(
            {
              url: "loadDiscussionList.php",
              type: "POST",
              async: true,
              data:{
                storyID: s_id,
                updateDiscussionList: true,
              },
              success: function(result){
                $("#discussion-list").html(result);
              }
            }
          );
        }
      );
    }
  );
</script>
</html>