<?php
  session_start()
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
  <div class="container-fluid" id="container">
    <div class="row">
      <div class="col-xl-2" id="sidebar">
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger">Discard</button>
        <a name="return" id="exit" class="btn btn-danger" href="#" role="button">Back to Story Page</a>
      </div>
      <div class="col-xl-10" contenteditable="true">
        
      </div>
    </div>
  </div>
</body>
</html>