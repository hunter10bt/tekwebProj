<?php
  include "connectdb.php";
  session_start();

  if(isset($_POST["loadChapters"])){
    
    $query = "SELECT chapterID,title,summary FROM chapter WHERE readable = 1 AND storyID = $_POST[storyID]";
    $chapterRes = mysqli_query($con, $query);
    $result = "";

    if ($chapterRes){
      while ($row = mysqli_fetch_array(($chapterRes))) {
        $result.= "
        <a href='reader.php?id=$row[0]' class='list-group-item list-group-item-action'>
          <div class='d-flex w-100 justify-content-between'>
            <h4 class='mb-1'>$row[1]</h5>
          </div>
          <p class='mb-1'>$row[2]</p>
        </a>";
      }
    }
    else {
      $result.= "There are currently no chapters.";
    }
  }

  echo $result;
  exit();
?>