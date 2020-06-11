<?php
  session_start();
  include "connectdb.php";
  $result = false;
  $today = gmdate('Y-m-d');
  try {
    //code...
    if(isset($_POST["newStory"]) && isset($_SESSION["uname"])){
      $query = "INSERT INTO `story` (dateAdded, title, author, summary) VALUES ('$today', '{$_POST["title"]}', '{$_SESSION["uname"]}','{$_POST["details"]}')";

      $result = mysqli_query($con, $query);
      if (isset($_POST["franchiseID"])){
        $idsearch = mysqli_query($con, "SELECT storyID FROM story WHERE title = '{$_POST["title"]}'");

        $id = mysqli_fetch_array($idsearch)[0];
        $tagAdd = mysqli_query($con, "INSERT INTO tagdetails VALUES ('{$_POST["franchiseID"]}','$id')");
        $result .= ": Tag added";
      }
    }
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo json_encode($result);
  exit();
?>