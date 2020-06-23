<?php
  session_start();
  include "connectdb.php";
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - ReadHere</title>
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
            echo "<a class='nav-link' href='signin.php?prevPage=index.php'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=index.php'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=index.php'>Sign Out</a>";
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
      </ul>
    </div>
  </nav>
  <div class="container-fluid"id="container">
    <div class="jumbotron">
      <h1 class="display-3">Welcome to ReadHere</h1>
      <!--<p class="lead">Jumbo helper text</p>-->
      <hr class="my-2">
      <p>
        <?php 
          if(isset($_SESSION["uname"])){
            echo "Welcome back, {$_SESSION["uname"]}!";
          }
          else {
            echo "Currently Not logged in.";
          }
        ?>
      </p>
      <!--<p class="lead">
        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
      </p>-->
    </div>
    <h2>Franchise List</h2>
    <div class="list-group">
      <?php
      $query = "SELECT `Franchise Name`,`franchiseIDName` from `franchise` WHERE readable = 1";
      $result = mysqli_query($con, $query);

      if($result){
        while ($row = mysqli_fetch_array($result)){
          echo '<a href="franchise.php?id='.$row[1].'" class="list-group-item list-group-item-action list-group-item-primary">'.$row[0].'</a>';
        }
      }
      else {
        echo '<li class="list-group-item">Unable to execute query</li>';
      }

    ?>
    </div>
  </div>
</body>
</html>