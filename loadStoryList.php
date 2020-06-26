<?php
  include "connectdb.php";
  $result = "";

  try {
    if(isset($_POST["updateStoryList"])){
      $addFilter = "";
      if (isset($_POST["id"])) {
        $addFilter = " AND storyID=any(SELECT storyID FROM tagdetails WHERE franchiseID = '{$_POST["id"]}')";
      }
      elseif(isset($_POST["search"])){
        $addFilter = " AND title LIKE '%{$_POST["search"]}%'";
      }
      elseif(isset($_POST["username"])) {
        $addFilter = " AND author = '{$_POST["username"]}'";
      }
      $query = "SELECT storyID,title,author,summary FROM story WHERE readable = 1{$addFilter} ORDER BY storyID desc";
      $storyRes = mysqli_query($con, $query);
  
      if ($storyRes) {
        $count = 0;
        while($row = mysqli_fetch_array($storyRes)){
          $result .= "
          <a href='story.php?id=$row[0]' class='list-group-item list-group-item-action'>
            <div class='d-flex w-100 justify-content-between'>
              <h4 class='mb-1'>$row[1]</h5>
              <!--<small>3 days ago</small>-->
            </div>
            <p class='mb-1'>$row[3]</p>
            <small>By $row[2]</small>
          </a>";
          $count++;
        }
        if ($count < 1) {
          $result = "There are currently no stories for this franchise.";
        }
      }
      else {
        $result = "Cannot find list of stories for this franchise";
      }
    } else {
      $result = "No signal received";
    }
  } catch (Throwable $th) {
    $result = $th -> getMessage();
  }

  echo $result;
  exit();
?>