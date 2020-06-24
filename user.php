<?php
  session_start();
  if (!isset($_GET["uname"])) {
    header("location: index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo "{$_GET["uname"]}";?> - User - ReadHere</title>
  <script src="jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light fixed-top" id="navbar">
    <a class="navbar-brand" href="index.php">ReadHere</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <?php
          if(!isset($_SESSION["uname"])){
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signin.php?prevPage=user.php?id={$_GET["uname"]}'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=user.php?id={$_GET["uname"]}'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=user.php?id={$_GET["uname"]}'>Sign Out</a>";
            echo '</li>';
          }
        ?>
        <li class='nav-item'>
          <a class='nav-link' href='about.php'>About</a>
        </li>
        <li class='nav-item'>
          <a href='stories.php' class='nav-link'>Stories</a>
        </li>
        <li class='nav-item'>
          <a href='discussions.php' class='nav-link'>Discussions</a>
        </li>
        <li class='nav-item'>
          <a href='franchises.php' class='nav-link'>Franchises</a>
        </li>
        <li class='nav-item'>
          <a href='users.php' class='nav-link'>Users</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
        <select class="form-control mr-sm-2 custom-select" name="searchType" id="searchType">
          <option value='story'>Story Title</option>
          <option value='franchise'>Franchise Title</option>
          <option value='discussion'>Discussion Title</option>
          <option value='user'>User</option>
        </select>
        <input type="text" name="searchTitle" id="searchTitle" class="form-control mr-sm-2" placeholder="search...">
        <button class='btn btn-success' type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid" id="container">
    <div id="result" style="width:100%"></div>
  </div>
  <nav class="navbar navbar-light bg-light fixed-bottom">
    <form class="form-inline">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="unameDisplay"><?php echo $_GET["uname"]; ?></span>
        </div>
        <select class="form-control custom-select" name="displayControl" id="displayControl">
          <option value='story'>Stories</option>
          <option value='comment'>Comments</option>
          <option value='discussion'>Discussions</option>
        </select>
      </div>
    </form>
  </nav>
</body>
<script>
  function loadComments(){
    var uname = $('#unameDisplay').text();

    $.ajax(
      {
        url: 'loadCommentList.php',
        type: 'POST',
        data: {
          loadComment: true,
          username: uname
        },
        success: function(result){
          $('#result').html(result);
        },
        error: function(jqXHR, status, errorThrown){
          console.log(errorThrown);
        }
      }
    );
  }

  function loadStories(){
    var uname = $('#unameDisplay').text();

    $.ajax(
      {
        url: 'loadStoryList.php',
        type: 'POST',
        data: {
          updateStoryList: true,
          username: uname
        },
        success: function(result){
          $('#result').html(result);
        },
        error: function(jqXHR, status, errorThrown){
          console.log(errorThrown);
        }
      }
    );
  }

  function loadDiscussions(){
    var uname = $('#unameDisplay').text();

    $.ajax(
      {
        url: 'loadDiscussionList.php',
        type: 'POST',
        data: {
          updateDiscussionList: true,
          username: uname
        },
        success: function(result){
          $('#result').html(result);
        },
        error: function(jqXHR, status, errorThrown){
          console.log(errorThrown);
        }
      }
    );
  }

  $(
    function(){
      loadStories();

      $("#displayControl").change(
        function(){
          if ($(this).val() == 'story') loadStories();
          else if ($(this).val() == 'comment') loadComments();
          else if ($(this).val() == 'discussion') loadDiscussions();
        }
      );
    }
  );
</script>
</html>