<?php
  include "connectdb.php";
  session_start();

  $uname = $_POST["uname"];
  $pass = $_POST["password"];

  $query = "SELECT `password` FROM `user` WHERE username='$uname' AND readable=1";
  $result = mysqli_query($con, $query);
  $passCheck = mysqli_fetch_array($result)[0];
  
  if (isset($passCheck)){
    if ($passCheck == $pass){
      $_SESSION["uname"] = $uname;
      if (isset($_POST["prevPage"]))
        header("location: {$_POST["prevPage"]}");
      else
        header("location: index.php");
    }
    else{
      header("location: signin.php?prevPage={$_POST["prevPage"]}&pass=false");
    }
  }
  else{
    header("location: signin.php?prevPage={$_POST["prevPage"]}&registered=false");
  }
?>