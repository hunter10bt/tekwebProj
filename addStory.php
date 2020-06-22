<?php
  session_start();
  include "connectdb.php";
  $result = "";
  $today = gmdate('Y-m-d');
  try {
    if(isset($_POST["newStory"]) && isset($_SESSION["uname"])){
      $query = "INSERT INTO `story` (dateAdded, title, author, summary) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}','{$_POST["details"]}')";

      $add = mysqli_query($con, $query);
      if ($add) {
        $result = "Story";
        if (isset($_POST["franchiseID"])){
          $idsearch = mysqli_query($con, "SELECT storyID FROM story WHERE title = '{$_POST["title"]}'");
  
          $id = mysqli_fetch_array($idsearch)[0];
          $tagAdd = mysqli_query($con, "INSERT INTO tagdetails VALUES ('{$_POST["franchiseID"]}','$id')");
          $result .= " and tag";
        }
        $result .= " succesfully added.";
      } else {
        $result = "Failed to add story.";
      }
    }
    else {
      if (!isset($_POST["newStory"])) $result .= " No signal received.";
      if (!isset($_SESSION["uname"])) $result .= " Unable to add story because you are not logged in.";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>