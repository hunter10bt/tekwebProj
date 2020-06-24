<?php
  include "connectdb.php";

  try {
    if (isset($_POST['loadUserList'])) {
      if (isset($_POST['search'])) {
        $filter = "WHERE username LIKE '%{$_POST["search"]}%'";
      } else {
        $filter = "";
      }
      $query = "SELECT username, readable FROM user {$filter} ORDER BY username ASC";
      $resultSet = mysqli_query($con, $query);

      if ($resultSet) {
        $count = 0;
        while (($row = mysqli_fetch_array($resultSet)) != NULL) {
          if ($row['readable'] == 1) {
            $count++;
            echo "<a href='user.php?uname={$row["username"]}' class='list-group-item list-group-item-action'>{$row["username"]}</a>";
          }
        }
        if ($count < 1) {
          echo "There are no users with matching username";
        }
      } else {
        echo "Unable to find users matching the criteria.";
      }
    } else {
      echo "No signal received";
    }
  } catch (Throwable $th) {
    echo $th->getMessage();
  }

  exit();
?>