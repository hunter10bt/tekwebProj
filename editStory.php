<?php
  session_start();
  include "connectdb.php";
  header("Content-type: text/x-json");
  $result = [];
  $result["bool"] = false;
  $result["message"] = '';

  try {
    if (isset($_SESSION["uname"]) and isset($_POST["id"]) and (isset($_POST["edit"]) or isset($_POST["delete"]))) {
      $storyInfo = mysqli_query($con, "SELECT author FROM story WHERE storyID = {$_POST["id"]}");
      $authorRow = mysqli_fetch_array($storyInfo);
      $author = $authorRow["author"];

      if ($author == $_SESSION["uname"]) {
        if (isset($_POST["edit"])) {
          $set = " SET title='{$_POST["title"]}', summary='{$_POST["summary"]}'";
        } elseif(isset($_POST["delete"])) {
          $set = " SET readable = 0";
        }
        $query = "UPDATE story $set WHERE storyID={$_POST["id"]}";

        $result["bool"] = mysqli_query($con, $query);
        if ($result["bool"]) {
          if (isset($_POST["edit"])) $result["message"] = "Edit successful.";
          elseif (isset($_POST["delete"])) $result["message"] = "Delete successful."; 
        } else {
          $err = mysqli_error($con);
          if (isset($_POST["edit"])) $result["message"] = "Edit failed. $err";
          elseif (isset($_POST["delete"])) $result["message"] = "Delete failed. $err"; 
          else $result["message"] = "$err";
        }
      } else {
        $result["message"] = "Unable to edit or delete the story as you are not the author.";
      }
    } else {
      if (!isset($_SESSION["uname"])) $result["message"] = "Unable to edit or delete the story as you are not logged in.";
      if (!isset($_POST["id"])) $result["message"] .= " No target ID received.";
      if (!(isset($_POST["edit"]) or isset($_POST["delete"])))$result["message"] .= " No edit/delete signal received.";
    }
  } catch (Throwable $th) {
    $result["message"] = $th->getMessage();
  }

  echo json_encode($result);
  exit();
?>