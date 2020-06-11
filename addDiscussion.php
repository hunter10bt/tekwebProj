<?php
  session_start();
  include "connectdb.php";
  $today = gmdate('Y-m-d');

  if(isset($_POST["newDiscussion"]) && isset($_SESSION["uname"])){
    if (isset($_POST["franchiseID"])){
      $query = "INSERT INTO `discussion` (dateCreated, title, user, franchiseID, content) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}', '{$_POST["franchiseID"]}', '{$_POST["details"]}')";

      $result = mysqli_query($con, $query);
      echo json_encode($result);
    }
    elseif (isset($_POST["storyID"])){
      $query = "INSERT INTO `discussion` (dateCreated, title, user, storyID, content) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}', '{$_POST["storyID"]}', '{$_POST["details"]}')";

      $result = mysqli_query($con, $query);
      echo json_encode($result);
    }
  }
  else {
    echo json_encode("Unable to add discussion");
  }
  exit();
?>