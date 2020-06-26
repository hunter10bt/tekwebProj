<?php
  include "connectdb.php";
  session_start();
  $result = "";

  try {
    if(isset($_POST["loadChapters"])){
      $query = "SELECT chapterID,title,summary FROM chapter WHERE readable = 1 AND storyID = $_POST[storyID] ORDER BY chapterID DESC";
      $chapterRes = mysqli_query($con, $query);
      $result = "";

      if ($chapterRes){
        $count = 0;
        while ($row = mysqli_fetch_array(($chapterRes))) {
          $result.= "
          <a href='reader.php?id=$row[0]' class='list-group-item list-group-item-action'>
            <div class='d-flex w-100 justify-content-between'>
              <h4 class='mb-1'>$row[1]</h5>
            </div>
            <p class='mb-1'>$row[2]</p>
          </a>";
          $count += 1;
        }
        if($count < 1){
          $result .= "There are currently no chapters.";
        }
      }
      else {
        $result .= "Cannot find chapters.";
      }
    }
    else {
      $result = "No signal received.";
    }
  } catch (Throwable $th) {
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>