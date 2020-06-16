<?php
  session_start();
  include "connectdb.php";
  $result = false;

  try {
    //code...
    if (isset($_POST["saveChapter"])) {
      # code...
      $chapterID = $_POST["chapterID"];
      $query = "SELECT author, storyID FROM story WHERE storyID = ANY(SELECT storyID FROM chapter WHERE chapterID = $chapterID)";
      $authorResult = mysqli_query($con, $query);
      if($authorResult){
        $row = mysqli_fetch_array($authorResult);
        $authorID = $row[0];
        $storyID = $row[1];
        $isEditor = false;
  
        if(isset($_SESSION["uname"]) and $_SESSION["uname"] == $authorID){
          $isEditor = true;
        }
        if(!$isEditor){
          $result = "Not an editor.";
        }
        else {
          $filename = "./chapters/$_POST[chapterID].json";
          $result = file_put_contents($filename, json_encode($_POST["paragraphs"]));
        }
      }
      else {
        $result = "Cannot find author ID";
      }
    }
    $result = false;
  } catch (\Throwable $th) {
    //throw $th;
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>