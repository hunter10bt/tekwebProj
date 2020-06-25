<?php
  include "connectdb.php";
  header("Content-type: text/x-json");

  $result = [];
  $result["bool"] = false;
  $result["message"] = "";

  try {
    if (isset($_POST["signup"])) {
      $query = "INSERT INTO user (username, password) VALUES ('%s','%s')";
      $result["bool"] = mysqli_query($con, sprintf($query, $_POST["user"], md5($_POST["pass"])));
      $result["message"] = "Sign-up successful";
    } else {
      $result["bool"] = false;
      $result["message"] = "No sign-up signal received.";
    }
  } catch (\Throwable $th) {
    $result["bool"] = false;
    $result["message"] = $th->getMessage();
  }

  echo json_encode($result);
  exit();
?>