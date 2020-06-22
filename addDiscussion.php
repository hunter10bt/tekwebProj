<?php
  session_start();
  include "connectdb.php";
  $today = gmdate('Y-m-d');
  $result = "";

  try {
    if(isset($_POST["newDiscussion"]) && isset($_SESSION["uname"])){
      $query = "";
      if (isset($_POST["franchiseID"])){
        $query = "INSERT INTO `discussion` (dateCreated, title, user, franchiseID, content) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}', '{$_POST["franchiseID"]}', '{$_POST["details"]}')";
      }
      elseif (isset($_POST["storyID"])){
        $query = "INSERT INTO `discussion` (dateCreated, title, user, storyID, content) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}', '{$_POST["storyID"]}', '{$_POST["details"]}')";
      }
      $check = mysqli_query($con, $query);
      if ($check) {
        $result = "Successfully added discussion.";
      } else {
        $result = "Adding discussion failed.";
      }
    }
    else {
      if(!isset($_POST["newDiscussion"])) $result .= " No signal received.";
      if(!isset($_SESSION["uname"])) $result .= " You are not logged in. You cannot add discussion.";
    }
  } catch (Throwable $th) {
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>