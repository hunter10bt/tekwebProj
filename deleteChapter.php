<?php
  session_start();
  include "connectdb.php";
  $result = [];
  $result['bool'] = false;
  $result['message'] = "";

  try {
    if (isset($_SESSION['uname']) and isset($_POST['deleteChapter'])) {
      $query = "SELECT author, storyID, readable FROM story WHERE storyID = ANY(SELECT storyID FROM chapter WHERE chapterID = {$_POST['id']})";
      $authorResult = mysqli_query($con, $query);
      if($authorResult){
        $row = mysqli_fetch_array($authorResult);
        $authorID = $row[0];
        $storyID = $row[1];
        $readable = $row['readable'];
        $isEditor = false;

        if(isset($_SESSION["uname"]) and $_SESSION["uname"] == $authorID){
          $isEditor = true;
        }
        if ($readable == 0) {
          $result['message'] = 'Unable to delete story as the story does not exist.';
        } else {
          $query = "UPDATE chapter SET readable = 0 WHERE chapterID = {$_POST['id']}";
          $result['bool'] = mysqli_query($con, $query);
          if ($result['bool']) {
            $result['message'] = "Chapter deletion successful.";
          } else {
            $err = mysqli_error($con);
            $result['message'] = "Chapter deletion failed. $err";
          }
        }
      } else {
        $result['message'] .= " Unable to delete chapter as the system cannot find the author information.";
      }
    } else {
      if (!isset($_SESSION['uname'])) $result['message'] .= " Unable to delete chapter as you are not logged in.";
      if (!isset($_SESSION['deleteChapter'])) $result['message'] .= " Unable to delete chapter as the signal is not received.";
    }
  } catch (Throwable $th) {
    $result['message'] = $th -> getMessage();
  }

  echo json_encode($result);
  exit();
?>