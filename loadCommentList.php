<?php
  session_start();
  include "connectdb.php";
  $result = "";

  function loadCommentFromComment($commentID, $con){
    $query = "SELECT commentID, comment, user FROM comment WHERE readable = 1 AND targetCommentID = $commentID";

    $commentResult = mysqli_query($con, $query);
    if ($commentResult) {
      echo '<ul class="list-group">';

      while (($row = mysqli_fetch_array($commentResult)) != null) {        
        //Loads this comment
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        echo "<p class='mb-1'>{$row['comment']}</p>";
        //Loads the buttons
        if(isset($_SESSION["uname"])){
          echo "<div class='btn-group' role='group'>";
          echo "<button type='button' class='btn btn-add-comment btn-primary' targetType='comment' targetCommentID='$row[commentID]'>Add Comment</button>";
          echo "<button type='button' class='btn btn-danger btn-primary' targetType='comment'  targetCommentID='$row[commentID]'>Report</button>";
          echo "</div>";
        }

        //Recursively loads comments to this comment
        loadCommentFromComment($row['commentID'], $con);
        
        echo "</li>";
      }
      echo '</ul>';
    }
    else {
      echo "<h3>There are no comments</h3>";
    }
  }

  function loadCommentFromThread($threadID, $con){
    $query = "SELECT commentID, comment, user FROM comment WHERE readable = 1 AND discussionID = $threadID";

    $commentResult = mysqli_query($con, $query);
    if ($commentResult) {
      echo '<ul class="list-group">';

      while (($row = mysqli_fetch_array($commentResult)) != null) {        
        //Loads this comment
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        echo "<p class='mb-1'>{$row['comment']}</p>";
        //Loads the buttons
        if(isset($_SESSION["uname"])){
          echo "<div class='btn-group' role='group'>";
          echo "<button type='button' class='btn btn-add-comment btn-primary' targetType='comment' targetCommentID='$row[commentID]'>Add Comment</button>";
          echo "<button type='button' class='btn btn-danger btn-primary' targetType='comment'  targetCommentID='$row[commentID]'>Report</button>";
          echo "</div>";
        }

        //Recursively loads comments to this comment
        loadCommentFromComment($row['commentID'], $con);
        
        echo "</li>";
      }
      echo '</ul>';
    }
    else {
      echo "<h3>There are no comments</h3>";
    }
  }

  try {
    if (isset($_POST["loadComment"]) and isset($_POST["discussionID"])) {
      loadCommentFromThread($_POST["discussionID"], $con);
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
    echo $result;
  }
  exit();
?>