<?php
  session_start();
  include "connectdb.php";
  if(!isset($_GET['id'])){
    header("location: index.php");
  }
  else {
    $franchiseID = $_GET["id"];
    $info = mysqli_query($con, "SELECT `Franchise Name`, `Summary` FROM franchise WHERE franchiseIDName='$franchiseID' AND readable=1");

    $row = mysqli_fetch_array($info);
    if($row == null){
      header("location: index.php");
    }
    else {    
      $name = $row[0];
      $summary = $row[1];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Franchise - ReadHere</title>
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
      <div class="col-xl-10" style="padding-left: 2.5%; padding-right: 2.5%;">
        <div class="row">
          <div class="tab-content" id="nav-tabContent" style="width: max-content; ">
            <div class="tab-pane fade show active" id="list-about" role="tabpanel" aria-labelledby="list-about-list">
              <?php
                echo "<h1>$name</h1>";
                echo "$summary";
              ?>
            </div>
            <div class="tab-pane fade" id="list-story" role="tabpanel" aria-labelledby="list-story-list">
              <h2>List of Stories</h2>
              <div class="list-group" id="story-list">
                <?php
                  $query = "SELECT storyID,title,author,summary FROM story WHERE readable = 1 AND storyID=any(SELECT storyID FROM tagdetails WHERE franchiseID = '$franchiseID') ORDER BY storyID desc";
                  $storyRes = mysqli_query($con, $query);

                  if ($storyRes) {
                    while($row = mysqli_fetch_array($storyRes)){
                      echo "
                      <a href='story.php?id=$row[0]' class='list-group-item list-group-item-action'>
                        <div class='d-flex w-100 justify-content-between'>
                          <h4 class='mb-1'>$row[1]</h5>
                          <!--<small>3 days ago</small>-->
                        </div>
                        <p class='mb-1'>$row[3]</p>
                        <small>By $row[2]</small>
                      </a>";
                    }
                  }
                  else {
                    echo "There are currently no stories for this franchise";
                  }
                ?>
              </div>
            </div>
            <div class="tab-pane fade" id="list-discussions" role="tabpanel" aria-labelledby="list-discussions-list">
              <h2>List of Discussions</h2>
              <div class="list-group" id="discussion-list">
              <?php
                  $query = "SELECT discussionID,title,user,summary FROM discussion WHERE readable = 1 AND franchiseID = '$franchiseID'";
                  $discussionRes = mysqli_query($con, $query);

                  if ($discussionRes) {
                    while($row = mysqli_fetch_array($discussionRes)){
                      echo "
                      <a href='story.php?id=$row[0]' class='list-group-item list-group-item-action'>
                        <div class='d-flex w-100 justify-content-between'>
                          <h4 class='mb-1'>$row[1]</h5>
                          <!--<small>3 days ago</small>-->
                        </div>
                        <p class='mb-1'>$row[3]</p>
                        <small>By $row[2]</small>
                      </a>";
                    }
                  }
                  else {
                    echo "No discussions.";
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-2">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-about-list" data-toggle="list" href="#list-about" role="tab" aria-controls="about">About</a>
          <a class="list-group-item list-group-item-action" id="list-story-list" data-toggle="list" href="#list-story" role="tab" aria-controls="story">List of Stories</a>
          <a class="list-group-item list-group-item-action" id="list-discussions-list" data-toggle="list" href="#list-discussions" role="tab" aria-controls="discussions">List of Discussions</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>