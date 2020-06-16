<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    //code...
    if (isset($_POST["loadChapter"]) && isset($_POST["chapterID"])) {
      # code...
      $filename = "./chapters/$_POST[chapterID].json";
      $json = file_get_contents($filename);

      if ($json) {
        # code...
        $array = json_decode($json);

        foreach ($array as $paragraph) {
          # code...
          $result .= "<div>$paragraph</div>";
        }
      }
      else {        
        $result = "Unable to read json";
      }
    }
    else {
      $result = false;
    }
    
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>