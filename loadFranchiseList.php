<?php
  session_start();
  include "connectdb.php";
  $result = "";

  try {
    if (isset($_SESSION["adminName"]) and isset($_POST["loadFranchiseList"])) {
      $query = "SELECT franchiseIDName, `Franchise Name` FROM franchise WHERE readable = 1";
      if (isset($_POST['searchName'])) {
        $query .= " AND `Franchise Name` LIKE '%{$_POST['searchName']}%'";
      }
      $query .= " ORDER by `Franchise Name` ASC";

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
      if (!isset($_SESSION["adminName"])) $result .= "Access denied. ";
      if (!isset($_SESSION["loadFranchiseList"])) $result .= "No signal received. ";
    }
  } catch (Throwable $th) {
    $result = $th->getMessage();
  }

  echo $result;
  exit();
?>