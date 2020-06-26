<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<script src="jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Franchises - ReadHere</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light fixed-top" id="navbar">
    <a class="navbar-brand" href="index.php">ReadHere</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <?php
          if(!isset($_SESSION["uname"])){
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signin.php?prevPage=franchises.php'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=franchises.php'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=franchises.php'>Sign Out</a>";
            echo '</li>';
          }
        ?>
        <li class='nav-item'>
          <a class='nav-link' href='about.php'>About</a>
        </li>
        <li class='nav-item'>
          <a href='stories.php' class='nav-link'>Stories</a>
        </li>
        <li class='nav-item'>
          <a href='discussions.php' class='nav-link'>Discussions</a>
        </li>
        <li class='nav-item'>
          <a href='franchises.php' class='nav-link'>Franchises</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
        <select class="form-control mr-sm-2 custom-select" name="searchType" id="searchType">
          <option value='story'>Story</option>
          <option value='franchise'>Franchise</option>
          <option value='discussion'>Discussion</option>
        </select>
        <input type="text" name="searchTitle" id="searchTitle" class="form-control mr-sm-2" placeholder="search by title...">
        <button class='btn btn-success' type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid" id="container">
    <div class="form-group">
      <label for="franchiseTitleSearch">Search Franchise by title:</label>
      <input type="text" class="form-control" name="franchiseTitleSearch" id="franchiseTitleSearch" aria-describedby="franchiseSearchHelp" placeholder="Search by title...">
      <small id="franchiseSearchHelp" class="form-text text-muted">Press Enter to search while typing.</small>
    </div>
    <div id="searchResult" class="list-group"></div>
  </div>
</body>
<script>
  function loadFranchiseList() {
    var title = $('#franchiseTitleSearch').val();

    $.ajax(
      {
        url: 'loadFranchiseList.php',
        type: 'POST',
        data: {
          loadFranchiseList: true,
          searchName: title,
        },
        success: function(result){
          $('#searchResult').html(result);
        },
        error: function(jqXHR, status, errorThrown){
          $('#searchResult').html(errorThrown);
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  $(
    function(){
      <?php if(isset($_GET['search'])) echo "$('#franchiseTitleSearch').val('{$_GET['search']}');\n";?>
      loadFranchiseList();

      $('#franchiseTitleSearch').on(
        'change',
        function(){
          loadFranchiseList();
        }
      );
    }
  )
</script>
</html>