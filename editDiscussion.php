<?php
  session_start();
  include "connectdb.php";
  header("Content-type: text/x-json");
  $result = [];
  $result["message"] = "";
  $result["bool"] = false;

  try {
    //code...
    if ((isset($_POST["edit"]) or isset($_POST["delete"])) and isset($_POST["discussionID"])) {
      # code...
      $query = "UPDATE discussion";
      if(isset($_POST["edit"]))
        $query .= " SET title = '{$_POST["title"]}', content = '{$_POST["content"]}'";
      elseif(isset($_POST["delete"]))
        $query .= " SET readable = 0";

      $query .= " WHERE discussionID = {$_POST["discussionID"]}";
      $result["bool"] = mysqli_query($con, $query);

      if ($result["bool"]){
        if(isset($_POST["edit"]))
          $result["message"] = "Edit successful.";
        elseif(isset($_POST["delete"]))
          $result["message"] = "Delete Successful";
      }
      else {
        if(isset($_POST["edit"]))
          $result["message"] = "Edit failed.";
        elseif(isset($_POST["delete"]))
          $result["message"] = "Delete failed";
      }
    } else {
      # code...
      if (!(isset($_POST["edit"]) or isset($_POST["delete"]))) $result["message"] = "No signal received";
      if (!isset($_POST["discussionID"])) $result["message"] = "No target discussion ID received";
    }
    
  } catch (Throwable $th) {
    //throw $th;
    $result["message"] = $th -> getMessage();
  }

  echo json_encode($result);
  exit();
?>