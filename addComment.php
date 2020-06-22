<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    if(isset($_POST["addComment"]) and isset($_POST["targetType"])){
      if($_POST["targetType"] == 'discussion'){
        $query = "INSERT INTO comment (comment, discussionID, user) VALUES ('{$_POST["comment"]}', '{$_POST["targetDiscussionID"]}', '{$_SESSION["uname"]}')";
      }
      elseif ($_POST["targetType"] == 'comment') {
        $query = "INSERT INTO comment (comment, targetCommentID, user) VALUES ('{$_POST["comment"]}', '{$_POST["targetcommentid"]}', '{$_SESSION["uname"]}')";
      }

      $check = mysqli_query($con, $query);
      if ($check) {
        $result = "Successfully added comment.";
      } else {
        $result = "Adding comment failed";
      }
    }
    else {
      if (!isset($_POST["addComment"])) $result .= " No signal received.";
      if (!isset($_POST["targetType"])) $result .= " No target type received";
    }
  } catch (Throwable $th) {
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>