<?php
  include "connectdb.php";
  $result = "";
  
  try {
    if(isset($_POST["updateDiscussionList"])){
      $query = "SELECT discussionID,title,user FROM discussion WHERE readable = 1";
      if(isset($_POST["franchiseID"])){
        $query .= " AND franchiseID = '{$_POST["franchiseID"]}'";
      }
      elseif (isset($_POST["storyID"])) {
        $query .= " AND storyID = $_POST[storyID]";
      }
      elseif (isset($_POST["search"])) {
        $query .= " AND title LIKE '%{$_POST["search"]}%'";
      }
      $query .= " ORDER BY discussionID DESC";
      $discussionRes = mysqli_query($con, $query);
      if ($discussionRes) {
        $count = 0;
        while($row = mysqli_fetch_array($discussionRes)){
          $result .= "
          <a href='forum.php?id=$row[0]' class='list-group-item list-group-item-action'>
            <div class='d-flex w-100 justify-content-between'>
              <h4 class='mb-1'>$row[1]</h5>
              <!--<small>3 days ago</small>-->
            </div>
            <small>By $row[2]</small>
          </a>";
          $count += 1;
        }
        if ($count < 1) {
          $result = "There are currently no discussions";
        }
      }
      else {
        $result = "Cannot find list of discussions.";
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