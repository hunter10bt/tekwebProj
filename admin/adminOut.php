<?php
  session_start();
  session_destroy();

  if(isset($_GET["prevPage"]))
    header("location: ".$_GET["prevPage"]);
  else
    header("location: admin.php");
?>