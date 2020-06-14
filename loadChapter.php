<?php
  session_start();

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
          echo "<p>$paragraph</p>";
        }
      }
    }
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>