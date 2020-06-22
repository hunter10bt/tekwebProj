<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<script src="jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About - ReadHere</title>
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
            echo "<a class='nav-link' href='signin.php?prevPage=about.php'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=about.php'>Sign Up</a>";
            echo '</li>';
          }
          else {

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=about.php'>Sign Out</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='#'>$_SESSION[uname]</a>";
            echo '</li>';
          }
        ?>
        <li class='nav-item'>
          <a class='nav-link' href='about.php'>About</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container-fluid" id="container">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-3">Welcome to ReadHere site!</h1>
        <p class="lead">This is a project made by August Berlin T (c14180003) and Nicholas K (c14180026)</p>
        </p>
      </div>
    </div>
    <div>
      <h1>Specifications</h1>
      <p>This website is built with these specifications:</p>
      <p>Apache 2.4.41</p>
      <p>MariaDB 10.4.8</p>
      <p>PHP 7.3.11 (VC15 X86 64bit thread safe) + PEAR</p>
      <p>phpMyAdmin 4.9.1</p>
      <p>Managed using XAMPP Control Panel Version 3.2.4.</p>
    </div>
  </div>
</body>
</html>