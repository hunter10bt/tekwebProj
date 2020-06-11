<?php
  session_start();
  include "connectdb.php";

  try {
    if(isset($_POST["newChapter"])){
      //Inserts to database
      
      //Creates file
      $filename = "./chapters/";
      // $file = fopen();
    }
    $result = true;
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo json_encode($result);
  exit();
?>