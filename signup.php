<?php
  session_start();

  if(isset($_SESSION["uname"])){
    if (isset($_GET["prevPage"]))
      header("location: ".$_GET["prevPage"]);
    else
      header("location: index.php");
  }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up-ReadHere</title>
  <script src="jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light fixed-top"  id="navbar">
    <a class="navbar-brand" href="index.php">ReadHere</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="signin.php">Sign In<span class="sr-only"></span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="signup.php">Sign Up<span class="sr-only">(current)</span></a>
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
    <div class="form-group">
      <label for="user">Username</label>
      <input type="text" class="form-control" name="user" id="user" aria-describedby="helpId" placeholder="Username...">
    </div>
    <div class="form-group">
      <label for="pass">Password</label>
      <input type="password" class="form-control" name="pass" id="pass" placeholder="New Password">
    </div>
    <div id="message"></div>
    <button id="register" class="btn btn-primary">Register</button>
  </div>
</body>
<script>
  function register(){
    var uname = $("#user").val();
    var pass = $("#pass").val();

    $.ajax(
      {
        url: "register.php",
        type: "POST",
        data: {
          user: uname,
          pass: pass,
          signup: true
        }, 
        dataType: "html", 
        error: function(jqXHR, textStatus, errorThrown){
          $("#passHelp").text(errorThrown);
        },
        success: function(result){
          check = JSON.parse(result);

          $("#message").text(check.message);
          if (check.bool) {
            target = "signin.php?prevPage=<?php if (isset($_GET["prevPage"])) echo $_GET["prevPage"]; else echo "index.php";?>";

            window.location.replace(target);
          }
        }
      }
    );
  }

  $(document).ready(
    function(){
      $("#register").click(
        function(){
          register();
        }
      );
    }
  );
</script>
</html>