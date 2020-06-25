<?php
  include "connectdb.php";
  session_start();

  header("Content-type: text/x-json");
  $uname = $_POST["uname"];
  $pass = $_POST["password"];
  $out = [];
  $out["success"] = false;

  try {
    if (isset($_POST["authenticate"])) {
      # code...
      $query = "SELECT `password` FROM `user` WHERE username='$uname' AND readable=1";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      
      if (isset($row)){
        $passCheck = $row[0];

        if ($passCheck == md5($pass)){
          $_SESSION["uname"] = $uname;
          $out["success"] = true;
          $out["message"] = "Login successful.";
        }
        else{
          $out["message"] = "Incorrect Password.";
        }
      }
      else{
        $out["message"] = "Username is not registered.";
      }
    } else {
      $out["message"] = "No authentication signal received.";
    }
  } catch (\Throwable $th) {
    //throw $th;
    $out["message"] = $th->getMessage();
  }

  echo json_encode($out);
  exit();
?>