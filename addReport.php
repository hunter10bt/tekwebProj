<?php
  // {
  //   addReport:true,
  //   title:title,
  //   targettype:targettype,
  //   targetcommentid:targetcommentid,
  //   targetDiscussionID:targetDiscussionID,
  //   details: details,
  //   userTgtID: usertgtID,
  //   storyID
  //   franchiseID
  // }
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    //code...
    if (isset($_POST["addReport"]) and isset($_SESSION["uname"]) and isset($_POST["targettype"])) {
      # code...
      if ($_POST["targettype"] == 'comment') {
        # code...
        $query = "INSERT INTO report(submitter, commentID, title, detail) VALUES ('{$_SESSION["uname"]}','{$_POST["targetcommentid"]}','{$_POST["title"]}','{$_POST["details"]}')";
      }
      elseif ($_POST["targettype"] == 'discussion') {
        # code...
        $query = "INSERT INTO report(submitter, discussionID, title, detail) VALUES ('{$_SESSION["uname"]}','{$_POST["targetDiscussionID"]}','{$_POST["title"]}','{$_POST["details"]}')";
      }
      $check = mysqli_query($con, $query);
      if ($check) {
        $result = "Report successfully sent.";
      } else {
        $result = "Failed to send report";
      }
    }
    else {
      if (!isset($_POST["addReport"])) $result .= " No signal received.";
      if (!isset($_SESSION["uname"])) $result .= " Report cannot be sent because you are not logged in.";
      if (!isset($_POST["targettype"])) $result .= " No target type received.";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>