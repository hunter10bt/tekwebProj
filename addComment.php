<?php
  session_start();
  include "connectdb.php";

  try {
    if(isset($_POST["addComment"]) and isset($_POST["targetType"])){
      if($_POST["targetType"] == 'discussion'){
        $query = "INSERT INTO comment (comment, targetCommentID, user) VALUES ('{$_POST["comment"]}', '{$_POST["targetCommentID"]}', '$_SESSION[uname]')";
      }
      elseif ($_POST["targetType"] == 'comment') {
        $query = "INSERT INTO comment (comment, targetCommentID, user) VALUES ('{$_POST["comment"]}', '{$_POST["targetCommentID"]}', '$_SESSION[uname]')";
      }

      $result = mysqli_query($con, $query);
    }
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>