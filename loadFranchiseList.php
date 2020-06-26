<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    if (isset($_POST["loadFranchiseList"])) {
      $addFilter = "";
      if (isset($_POST['searchName'])) {
        $addFilter = " AND `Franchise Name` LIKE '%{$_POST['searchName']}%'";
      }
      $query = "SELECT franchiseIDName, `Franchise Name` FROM franchise WHERE readable = 1{$addFilter} ORDER by `Franchise Name` ASC";

      $resultset = mysqli_query($con, $query);

      if ($resultset) {
        $count = 0;
        while (($row = mysqli_fetch_array($resultset)) != NULL) {
          $count++;
          $result .= "<a href='franchise.php?id={$row["franchiseIDName"]}' class='list-group-item list-group-item-action'>";
          $result .= "<p>{$row["Franchise Name"]}</p>";
          $result .= "</a>";
        }
        if ($count == 0) {
          $result = "There are no franchises matching the criteria";
        }
      } else {
        $result = "Unable to search at the moment";
      }
    } else {
      if (!isset($_SESSION["loadFranchiseList"])) $result .= "No signal received. ";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>