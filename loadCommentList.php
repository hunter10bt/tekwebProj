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
          echo "<button type='button' class='btn btn-primary btn-add-comment' targettype='comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#addCommentModal'>Add Comment</button>";
          echo "<button type='button' class='btn btn-danger btn-report' targettype='comment'  targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#reportModal'>Report</button>";
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
      echo '<h1>List of Comments</h1>';
      echo '<ul class="list-group">';

      while (($row = mysqli_fetch_array($commentResult)) != null) {        
        //Loads this comment
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        echo "<p class='mb-1'>{$row['comment']}</p>";
        //Loads the buttons
        if(isset($_SESSION["uname"])){
          echo "<button type='button' class='btn btn-primary btn-add-comment' targettype='comment' targetcommentid='{$row["commentID"]}'  data-toggle='modal' data-target='#addCommentModal'>Add Comment</button>";
          echo "<button type='button' class='btn btn-danger btn-report' targettype='comment'  targetcommentid='{$row["commentID"]}'  data-toggle='modal' data-target='#reportModal'>Report</button>";
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
    }else {
      if(!isset($_POST["loadComment"])) echo "No signal received.";
      if(!isset($_POST["discussionID"])) echo "No discussion ID received.";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
    echo $result;
  }
  exit();
?>