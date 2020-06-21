<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    //code...
    if ((isset($_POST["edit"]) or isset($_POST["delete"])) and isset($_POST["commentID"])) {
      # code...
      $query = "UPDATE comment";
      if(isset($_POST["edit"]))
        $query .= " SET comment = {$_POST["comment"]}";
      elseif(isset($_POST["delete"]))
        $query .= " SET readable = 0";

      $query .= " WHERE commentID = {$_POST["commentID"]}";
      $success = mysqli_query($con, $query);

      if ($success){
        if(isset($_POST["edit"]))
          $result .= "Edit successful.";
        elseif(isset($_POST["delete"]))
          $result .= "Delete Successful";
      }
      else {
        if(isset($_POST["edit"]))
          $result .= "Edit failed.";
        elseif(isset($_POST["delete"]))
          $result .= "Delete failed";
      }
    } else {
      # code...
      if (!(isset($_POST["edit"]) or isset($_POST["delete"]))) $result .= "No signal received";
      if (!isset($_POST["commentID"])) $result .= "No target comment ID received";
    }
    
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>