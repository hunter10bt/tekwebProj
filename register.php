<?php
  include "connectdb.php";

  $query = "INSERT INTO user (username, password) VALUES ('%s','%s')";
  $test = mysqli_query($con, sprintf($query, $_POST["user"], $_POST["pass"]));

  header("location: index.php?register=".$test);
?>