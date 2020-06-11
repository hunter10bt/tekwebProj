<?php
  session_start();
  include "connectdb.php";
  $today = gmdate('Y-m-d');

  try {
    if(isset($_POST["newChapter"])){
      //Inserts to database
      $query = "INSERT INTO chapter (title, storyID, summary) VALUES ('{$_POST["title"]}', $_POST[storyID], '{$_POST["summary"]}')";

      $result = mysqli_query($con, $query);

      if ($result){
        //Searches the chapter ID
        $search = "SELECT chapterID FROM chapter WHERE title='{$_POST["title"]}' AND storyID = $_POST[storyID]";
        $res = mysqli_query($con, $search);

        $id = mysqli_fetch_array($res)[0];

        if ($id){        //Creates file
          $filename = "./chapters/$id.txt";
          // $file = fopen();
          
          $result = true;
        }
        else{
          $result = false;
        }
      }
      else {
        $result = false;
      }
    }
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo json_encode($result);
  exit();
?>