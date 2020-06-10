<?php
  include "connectdb.php";
  
  if(isset($_POST["updateDiscussionList"])){
    $query = "SELECT discussionID,title,user,summary FROM discussion WHERE readable = 1 AND franchiseID = '{$_POST["id"]}'";
    $discussionRes = mysqli_query($con, $query);

    if ($discussionRes) {
      while($row = mysqli_fetch_array($discussionRes)){
        echo "
        <a href='forum.php?id=$row[0]' class='list-group-item list-group-item-action'>
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
      echo "No discussions.";
    }
    exit();
  }

?>