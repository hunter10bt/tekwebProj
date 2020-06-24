<?php
  session_start();
  include "connectdb.php";
  $result = "";

  function loadCommentFromComment($commentID, $con){
    $query = "SELECT commentID, comment, user,readable FROM comment WHERE targetCommentID = $commentID ORDER by commentID DESC";

    $commentResult = mysqli_query($con, $query);
    if ($commentResult) {
      echo '<ul class="list-group">';

      while (($row = mysqli_fetch_array($commentResult)) != null) {        
        //Loads this comment
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        if ($row["readable"] == 1) echo "<p class='mb-1'>{$row['comment']}</p>";
        else echo "<p>This comment has been deleted.</p>";
        //Loads the buttons
        if(isset($_SESSION["uname"]) and $row["readable"] == 1){
          //Add comment
          echo "<button type='button' class='btn btn-primary btn-add-comment' targettype='comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#addCommentModal'>Add Comment</button>";
          //Report
          echo "<button type='button' class='btn btn-danger btn-report' targettype='comment'  targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#reportModal'>Report</button>";
          if ($_SESSION["uname"] == $row['user']) {
            //Edit
            echo "<button type='button' class='btn btn-primary btn-edit-comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#editCommentModal'>Edit</button>";
            //Delete
            echo "<button type='button' class='btn btn-danger btn-delete-comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#deleteCommentModal'>Delete</button>";
          }
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
    $query = "SELECT commentID, comment, user, readable FROM comment WHERE discussionID = $threadID ORDER by commentID DESC";

    $commentResult = mysqli_query($con, $query);
    if ($commentResult) {
      echo '<h1>List of Comments</h1>';
      echo '<ul class="list-group">';

      while (($row = mysqli_fetch_array($commentResult)) != null) {        
        //Loads this comment
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        if ($row["readable"] == 1) echo "<p class='mb-1'>{$row['comment']}</p>";
        else echo "<p>This comment has been deleted.</p>";
        //Loads the buttons
        if(isset($_SESSION["uname"]) and $row["readable"] == 1){
          //Add comment
          echo "<button type='button' class='btn btn-primary btn-add-comment' targettype='comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#addCommentModal'>Add Comment</button>";
          //Report
          echo "<button type='button' class='btn btn-danger btn-report' targettype='comment'  targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#reportModal'>Report</button>";
          if ($_SESSION["uname"] == $row['user']) {
            //Edit
            echo "<button type='button' class='btn btn-primary btn-edit-comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#editCommentModal'>Edit</button>";
            //Delete
            echo "<button type='button' class='btn btn-danger btn-delete-comment' targetcommentid='{$row["commentID"]}' data-toggle='modal' data-target='#deleteCommentModal'>Delete</button>";
          }
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

  function loadCommentFromUsername($username, $con){
    $query = "SELECT commentID, comment, user, readable FROM comment WHERE user = $username ORDER by commentID DESC";
    $resultset = mysqli_query($con, $query);

    if ($resultset) {
      echo "<ul>";
      $count = 0;
      while (($row = mysqli_fetch_array($resultset)) != NULL) {
        $count++;
        echo "<li class='list-group-item list-group-item-action'>";
        echo "<div class='d-flex w-100 justify-content-between'><h5 class='mb-1'>{$row['user']}</h5></div>";
        if ($row["readable"] == 1) echo "<p class='mb-1'>{$row['comment']}</p>";
        else echo "<p>This comment has been deleted.</p>";
        echo "</li>";
      }
      if ($count == 0) {
        echo "There are no comments from this user.";
      }
      echo "</ul>";
    } else {
      echo "Cannot find list of comments from this user.";
    }
  }

  try {
    if (isset($_POST["loadComment"]) and isset($_POST["discussionID"])) {
      loadCommentFromThread($_POST["discussionID"], $con);
    }elseif (isset($_POST["loadComment"]) and isset($_POST["username"])) {
      loadCommentFromUsername($_POST["username"], $con);
    }
    else {
      if(!isset($_POST["loadComment"])) echo "No signal received.";
      if(!isset($_POST["discussionID"])) echo "No discussion ID received.";
      if(!isset($_POST["username"])) echo "No username received.";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
    echo $result;
  }
  exit();
?>