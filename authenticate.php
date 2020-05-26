<?php
  include "connectdb.php";
  session_start();

  $uname = $_POST["uname"];
  $pass = $_POST["password"];

  $query = "SELECT password FROM user WHERE username='%s' AND readable=1;";
  $passCheck = mysqli_fetch_array(mysqli_query($con, sprintf($query, $uname)))[0];
  
  if ($passCheck != FALSE){
    if ($passCheck == $pass){
      $_SESSION["uname"] = $uname;
      if (isset($_POST["prevPage"]))
        header("location: ".$_POST["prevPage"]);
      else
        header("location: index.php");
    }
    else{
      header("location: signin.php?prevPage=".$_POST["prevPage"]."&pass=false");
    }
  }
  else{
    header("location: signin.php?prevPage=".$_POST["prevPage"]."&registered=false");
  }
?>