<?php
  session_start();

  if (isset($_SESSION["uname"])) {
    # code...
    if (isset($_GET["prevPage"])){
      header("location: ".$_GET["prevPage"]);
    }
    else
      header("location: index.php");
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
  <title>Sign In - ReadHere</title>
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
          <a class="nav-link" href="signup.php?prevPage=<?php if (isset($_GET["prevPage"])) echo $_GET["prevPage"] ; else echo "index.php"; ?>">Sign Up<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid"id="container">
    <div class="form-group">
      <label for="uname">Username</label>
      <input type="text" class="form-control" name="uname" id="uname" aria-describedby="helpId" placeholder="Username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-describedby="passHelp">
      <small id="passHelp" class="text-muted">
      </small>
    </div>
    <button id="login" class="btn btn-primary">Log In</button>
  </div>
</body>
<script>
  function authenticate(){
    var uname = $("#uname").val();
    var password = $("#password").val();
    var redirect = "<?php if(isset($_GET["prevPage"])) echo $_GET["prevPage"]; else echo "index.php"; ?>";

    $.ajax(
      {
        url: "authenticate.php",
        type: "POST",
        dataType: "html",
        data: {
          authenticate: true,
          uname: uname,
          password: password
        },
        error: function(jqXHR, textStatus, errorThrown){
          $("#passHelp").text(errorThrown);
        },
        success: function(result){
          check = JSON.parse(result);
          
          $("#passHelp").text(check.message);
          if (check.success) {
            window.location.replace(redirect);
          }
        }
      }
    );
  }

  $(document).ready(
    function(){
      $("#login").click(
        function(){
          authenticate();
        }
      );
    }
  )
</script>
</html>