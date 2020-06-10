<?php
  include "connectdb.php";

  if(isset($_POST["loadChapters"])){
    
    $query = "SELECT chapterID,title,category,summary FROM chapter WHERE readable = 1 AND storyID = '{$_POST["storyID"]}'";
    $chapterRes = mysqli_query($con, $query);

    if ($chapterRes){
      while ($row = mysqli_fetch_array(($chapterRes))) {
        echo "
        <a href='reader.php?id=$row[0]' class='list-group-item list-group-item-action'>
          <div class='d-flex w-100 justify-content-between'>
            <h4 class='mb-1'>$row[1]</h5>
            <!--<small>3 days ago</small>-->
          </div>
          <p class='mb-1'>$row[3]</p>
          <small>By $row[2]</small>
        </a>";
      }
    }
    else {
      echo "There are currently no chapters.";
    }
  }
?>