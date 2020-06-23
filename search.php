<?php
  if(!isset($_GET['searchType'])){
    header('location: index.php');
  }

  if(!isset($_GET['searchTitle'])){
    if ($_GET['searchType'] == 'story') header("location: stories.php");
    elseif ($_GET['searchType'] == 'discussion') header("location: discussions.php");
    elseif ($_GET['searchType'] == 'franchise') header("location: franchises.php");
  }
  else{
    if ($_GET['searchType'] == 'story') header("location: stories.php?search={$_GET["searchTitle"]}");
    elseif ($_GET['searchType'] == 'discussion') header("location: discussions.php?search={$_GET["searchTitle"]}");
    elseif ($_GET['searchType'] == 'franchise') header("location: franchises.php?search={$_GET["searchTitle"]}");
  }

?>