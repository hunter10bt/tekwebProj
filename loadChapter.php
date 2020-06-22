<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    if (isset($_POST["loadChapter"]) && isset($_POST["chapterID"])) {
      $filename = "./chapters/$_POST[chapterID].json";
      $json = file_get_contents($filename);

      if ($json) {
        $array = json_decode($json);

        foreach ($array as $paragraph) {
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
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>