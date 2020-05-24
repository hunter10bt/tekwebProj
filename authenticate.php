<?php
  session_start();

  $uname = $_POST["uname"];
  $pass = $_POST["password"];

  $passCheck = "root";

  if (isset($passCheck)){
    if ($passCheck == $pass){
      $_SESSION["uname"] = $uname;
      if (isset($_POST["prevPage"]))
        header("location: ".$_POST["prevPage"]);
      else
        header("location: index.php");
    }
    else{
      header("location: signin.php?prevPage=".$_POST["prevPage"]);
    }
  }
?>