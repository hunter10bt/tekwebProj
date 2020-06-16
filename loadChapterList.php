<?php
  include "connectdb.php";
  session_start();

  if(isset($_POST["loadChapters"])){
    
    $query = "SELECT chapterID,title,summary FROM chapter WHERE readable = 1 AND storyID = $_POST[storyID]";
    $authorQuery = "SELECT author FROM story WHERE readable = 1 AND storyID = $_POST[storyID]";
    $authorRes = mysqli_query($con, $authorQuery);
    $chapterRes = mysqli_query($con, $query);
    $author = mysqli_fetch_array($authorRes)[0];
    $result = "";

    if ($chapterRes){
      while ($row = mysqli_fetch_array(($chapterRes))) {
        $result.= "
        <div class='list-group-item'> <div class='list-group list-group-horizontal-xl'>
        <a href='reader.php?id=$row[0]' class='list-group-item list-group-item-action'>
          <div class='d-flex w-100 justify-content-between'>
            <h4 class='mb-1'>$row[1]</h5>
          </div>
          <p class='mb-1'>$row[2]</p>
        </a>";
        if (isset($_SESSION["uname"])){
          if ($_SESSION["uname"] == $author){
            $result .= "<a class='list-group-item-primary list-group-item list-group-item-action' href='editor.php?id=$row[0]' role='button'>Edit</a>
            <button class='list-group-item-danger list-group-item list-group-item-action btn-delete' role='button' chapterID='$row[0]'>Delete</button>";
          }
        }
        $result .= "</div>
        </div>";
      }
    }
    else {
      $result.= "There are currently no chapters.";
    }
  }

  echo $result;
  exit();
?>