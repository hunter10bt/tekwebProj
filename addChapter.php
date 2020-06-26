<?php
  session_start();
  include "connectdb.php";
  $today = gmdate('Y-m-d');
  $result = "";

  try {
    if(isset($_POST["addChapter"])){
      //Inserts to database
      $query = "INSERT INTO chapter (title, storyID, summary) VALUES ('{$_POST["title"]}', '{$_POST["storyID"]}', '{$_POST["summary"]}')";

      $add = mysqli_query($con, $query);

      if ($add){
        //Searches the chapter ID
        $search = "SELECT chapterID FROM chapter WHERE title='{$_POST["title"]}' AND storyID = $_POST[storyID]";
        $res = mysqli_query($con, $search);

        $row = mysqli_fetch_array($res);

        if (isset($row)){        
          //Creates file
          $id = $row[0];
          $filename = "./chapters/$id.json";
          // $file = fopen();
          $paragraphs = ["", ""];
          $check = file_put_contents($filename, json_encode ($paragraphs));
          if ($check) {
            $result = "Successfully added chapter.";
          } else {
            $result = "Failed to add chapter.";
          }
          
        }
        else{
          $result = "Failed to add chapter.";
        }
      }
      else {
        $result = "Failed to add chapter.";
      }
    }
    else {
      $result = "No signal received.";
    }
  } 
  catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>