<?php
  session_start();
  include "connectdb.php";
  $today = gmdate('Y-m-d');
  $result = false;

  try {
    if(isset($_POST["addChapter"])){
      //Inserts to database
      $query = "INSERT INTO chapter (title, storyID, summary) VALUES ('{$_POST["title"]}', '{$_POST["storyID"]}', '{$_POST["summary"]}')";

      $result = mysqli_query($con, $query);

      if ($result){
        //Searches the chapter ID
        $search = "SELECT chapterID FROM chapter WHERE title='{$_POST["title"]}' AND storyID = $_POST[storyID]";
        $res = mysqli_query($con, $search);

        $row = mysqli_fetch_array($res);

        if (isset($row)){        
          //Creates file
          $id = $row[0];
          $filename = "./chapters/$id.json";
          // $file = fopen();
          $paragraphs = array([""]);
          $result = file_put_contents($filename, json_encode ($paragraphs));
        }
        else{
          $result = false;
        }
      }
      else {
        $result = false;
      }
    }
    else {
      $result = false;
    }
  } 
  catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>