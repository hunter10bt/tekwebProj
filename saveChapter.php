<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    if (isset($_POST["saveChapter"])) {
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
          $result = "You are not an editor. Changes will be discarded.";
        }
        else {
          $filename = "./chapters/$_POST[chapterID].json";
          $check = file_put_contents($filename, json_encode($_POST["paragraphs"]));
          if (is_int($check) and $check != false) {
            $result = "Saving chapter succesful.";
          } else {
            $result = "Failed to save chapter.";
          }
        }
      }
      else {
        $result = "Cannot find author ID";
      }
    }
    $result = false;
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>