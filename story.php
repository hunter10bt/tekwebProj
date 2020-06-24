<?php
  session_start();
  include "connectdb.php";
  if(!isset($_GET['id'])){
    header("location: index.php");
  }
  else {
    $storyID = $_GET["id"];
    $info = mysqli_query($con, "SELECT `title`, `summary`, `author` FROM story WHERE storyID='$storyID' AND readable=1");

    $row = mysqli_fetch_array($info);
    if($row == null){
      header("location: index.php");
    }
    else {    
      $name = $row[0];
      $summary = $row[1];
      $authorID = $row[2];
    }

    $isAuthor = false;
    if(isset($_SESSION["uname"]) and $authorID == $_SESSION["uname"]){
      $isAuthor = true;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<script src="jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Story - ReadHere</title>
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
            echo "<a class='nav-link' href='signin.php?prevPage=story.php?id=$storyID'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=story.php?id=$storyID'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='user.php?uname={$_SESSION['uname']}' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=story.php?id=$storyID'>Sign Out</a>";
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
        <li class='nav-item'>
          <a href='users.php' class='nav-link'>Users</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
        <select class="form-control mr-sm-2 custom-select" name="searchType" id="searchType">
          <option value='story'>Story Title</option>
          <option value='franchise'>Franchise Title</option>
          <option value='discussion'>Discussion Title</option>
          <option value='user'>User</option>
        </select>
        <input type="text" name="searchTitle" id="searchTitle" class="form-control mr-sm-2" placeholder="search...">
        <button class='btn btn-success' type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid"id="container">
    <div class="row">
      <div class="col-xl-2">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-about-list" data-toggle="list" href="#list-about" role="tab" aria-controls="about">About this Story</a>
          <?php
            echo "<a class='list-group-item list-group-item-action' id='list-chapters-list' data-toggle='list' href='#list-chapters' role='tab' aria-controls='chapters' storyID='$storyID'>List of Chapters</a>";
            echo "<a class='list-group-item list-group-item-action' id='list-discussions-list' data-toggle='list' href='#list-discussions' role='tab' aria-controls='discussions' storyID='$storyID'> Discussions </a>";
          ?>
          <div class="list-group">
            <?php
              if (isset($_SESSION["uname"])) {
                echo "<!-- New discussion modal button --><button type='button' class='list-group-item list-group-item-success' data-toggle='modal' data-target='#addDiscussionModal'>New Discussion</button>";
                if ($isAuthor) {
                  echo "<!-- Button trigger modal -->
                  <button type='button' class='list-group-item list-group-item-warning' data-toggle='modal' data-target='#editStoryModal'>
                    Edit Story Info
                  </button>";
                  echo "<!-- Delete Button trigger modal -->
                  <button type='button' class='list-group-item list-group-item-danger' data-toggle='modal' data-target='#deleteStoryModal'>
                    Delete Story
                  </button>";
                  echo "<!-- New chapter modal button --><button type='button' class='list-group-item list-group-item-success' data-toggle='modal' data-target='#addChapterModal'>New Chapter</button>";
                }
              }
            ?>
          </div>
          <?php
            if (isset($_SESSION["uname"])) {
              echo "<!-- Add discussion modal -->
              <div class='modal fade' id='addDiscussionModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='exampleModalLabel'>Add Discussion</h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                      </button>
                    </div>
                    <div class='modal-body'>
                      <div class='form-group'>
                        <label for='discussionTitleInput'>Discussion Title</label>
                        <input type='text' class='form-control' name='discussionTitleInput' id='discussionTitleInput' aria-describedby='discussionTitleHelp' placeholder='Insert title here...' maxlength='64'>
                        <small id='discussionTitleHelp' class='form-text text-muted'>Insert discussion title here</small>
                      </div>
                      <div class='form-group'>
                        <label for='discussionDetailsInput'>Details</label>
                        <textarea class='form-control' name='discussionDetailsInput' id='discussionDetailsInput' rows='5' maxlength='256'></textarea>
                      </div>
                    </div>
                    <div class='modal-footer'>
                      <button type='button' class='btn btn-danger' data-dismiss='modal'> Cancel </button>
                      <button type='button' class='btn btn-primary' id='adddiscussion' data-dismiss='modal'> Add Discussion </button>
                    </div>
                  </div>
                </div>
              </div>";
              if ($isAuthor) {
                echo "<!-- Edit Story Modal -->
                <div class='modal fade' id='editStoryModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
                  <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Edit Story Info</h5>
                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                      </div>
                      <div class='modal-body'>
                        <div class='form-group'>
                          <label for='storyTitle'>Story Title</label>
                          <input type='text' class='form-control' name='storyTitle' id='storyTitle'placeholder='insert title here...' maxlength='32' value='$name'>
                        </div>
                        <div class='form-group'>
                          <label for='storySummary'>Story Summary</label>
                          <textarea class='form-control' name='storySummary' rows='5' id='storySummary' maxlength='256'>$summary</textarea>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'> Cancel </button>
                        <button type='button' class='btn btn-primary' id='editStory' data-dismiss='modal'>Edit Story Info</button>
                      </div>
                    </div>
                  </div>
                </div>";

                echo "<!-- Delete Story Modal -->
                <div class='modal fade' id='deleteStoryModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
                  <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Delete Story</h5>
                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                          </button>
                      </div>
                      <div class='modal-body'>
                        Do you want to delete this story? This cannot be undone!
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'> Cancel </button>
                        <button type='button' class='btn btn-danger'  id='deleteStory' data-dismiss='modal'>Delete Story</button>
                      </div>
                    </div>
                  </div>
                </div>";

                echo "<!-- New chapter modal -->
                <div class='modal fade' id='addChapterModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                  <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Add Chapter</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        <div class='form-group'>
                          <label for='chapterTitleInput'>Chapter Title</label>
                          <input type='text' class='form-control' name='chapterTitleInput' id='chapterTitleInput' placeholder='Insert title here...' maxlength='64'>
                        </div>
                        <div class='form-group'>
                          <label for='summaryInput'>Summary</label>
                          <textarea class='form-control' name='summaryInput' id='summaryInput' rows='5' maxlength='128'></textarea>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                        <button type='button' class='btn btn-primary' id='addChapter' data-dismiss='modal'>Add Chapter</button>
                      </div>
                    </div>
                  </div>
                </div>";
              }
            }
          ?>
        </div>
      </div>
      <div class="col-xl-10">
        <div class="row">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-about" role="tabpanel" aria-labelledby="list-about-list">
              <?php
                echo "<h2>$name</h2>";
                echo "<p>$summary</p>";
                echo "<p>By $authorID</p>";
              ?>
            </div>
            <div class="tab-pane fade" id="list-chapters" role="tabpanel" aria-labelledby="list-chapters-list">
              <h2>List of Chapters</h2>
              <div class="list-group" id="list-group-chapters">
              </div>
            </div>
            <div class="tab-pane fade" id="list-discussions" role="tabpanel" aria-labelledby="list-discussions-list">
              <h2>List of Discussions</h2>
              <div class="list-group" id="discussion-list">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  function loadChapters(){
    var s_id = $("#list-chapters-list").attr("storyID");
    $.ajax(
      {
        url: "loadChapterList.php",
        type: "POST",
        async: true,
        data:{
          storyID: s_id,
          loadChapters: true,
        },
        success: function(result){
          $("#list-group-chapters").html(result);
        },
        error: function(jqXHR, status, errorThrown){
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  function loadDiscussions(){
    var s_id = $("#list-discussions-list").attr("storyID");
    $.ajax(
      {
        url: "loadDiscussionList.php",
        type: "POST",
        async: true,
        data:{
          storyID: s_id,
          updateDiscussionList: true,
        },
        success: function(result){
          $("#discussion-list").html(result);
        },
        error: function(jqXHR, status, errorThrown){
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  $(
    function(){
      loadChapters();
      loadDiscussions();

      $("#list-chapters-list").click(
        function(){
          loadChapters();
        }
      );

      $("#list-discussions-list").click(
        function(){
          loadDiscussions();
        }
      );

      <?php
        if (isset($_SESSION["uname"])) {
          echo "$('#adddiscussion').click(
            function(){
              var title = $('#discussionTitleInput').val();
              var details = $('#discussionDetailsInput').val();
              var initiator = $('#unameDisplay').text();
              var storyID = $('#list-discussions-list').attr('storyID');
              $('#discussionTitleInput').val('');
              $('#discussionDetailsInput').val('');
    
              $.ajax(
                {
                  url: 'addDiscussion.php',
                  type: 'POST',
                  async: true,
                  data: {
                    title: title,
                    details: details,
                    storyID: storyID,
                    newDiscussion: true,
                  },
                  success: function(show){
                    alert(show);
                    console.log(show);
                  },
                  error: function(jqXHR, status, errorThrown){
                    alert(errorThrown);
                    console.log(errorThrown);
                  },
                  complete: function(){
                    loadDiscussions();
                  }
                }
              );
            }
          );";
          if ($isAuthor) {
            echo "//Menambahkan chapter - IN PROGRESS
            $('#addChapter').click(
              function(){
                var title = $('#chapterTitleInput').val();
                $('#chapterTitleInput').val('');
                var summary = $('#summaryInput').val();
                $('#summaryInput').val('');
                var storyID = $('#list-chapters-list').attr('storyID');
      
                alert('Title: '+title);
                alert('Summary: '+summary);
                alert('Story ID: '+storyID);
      
                $.ajax(
                  {
                    url: 'addChapter.php',
                    type: 'POST',
                    data: {
                      addChapter: true,
                      title: title,
                      storyID: storyID,
                      summary: summary,
                    },
                    success: function(result){
                      alert(result);
                      console.log(result);
                    },
                    error: function(jqXHR, status, errorThrown){
                      alert(errorThrown);
                      console.log(errorThrown);
                    },
                    complete: function(){
                      loadChapters();
                    }
                  }
                );
              }
            );";
            
            echo "$('#editStory').click(
              function(){
                var id = $storyID;
                var title = $('#storyTitle').val();
                var summary = $('#storySummary').val();
                $('#storyTitle').val('');
                $('#storySummary').val('');
      
                $.ajax(
                  {
                    url: 'editStory.php',
                    type: 'POST',
                    data: {
                      id: id,
                      edit: true,
                      title: title,
                      summary: summary,
                    },
                    dataType: 'html',
                    success: function(result){
                      console.log(result);
                      check = JSON.parse(result);
                      alert(check.message);
                      console.log(check.message);
                      if (check.bool) {
                        window.location.reload(true);
                      }
                    },
                    error: function(jqXHR, code, errorThrown){
                      alert(errorThrown);
                      console.log(errorThrown);
                    }
                  }
                );
              }
            );";

            echo "$('#deleteStory').click(
              function(){
                var id = $storyID;
      
                $.ajax(
                  {
                    url: 'editStory.php',
                    type: 'POST',
                    data: {
                      delete: true,
                      id: id,
                    },
                    dataType: 'html',
                    success: function(result){
                      console.log(result);
                      check = JSON.parse(result);
                      alert(check.message);
                      console.log(check.message);
                      if (check.bool) {
                        window.location.reload(true);
                      }
                    },
                    error: function(jqXHR, code, errorThrown){
                      alert(errorThrown);
                      console.log(errorThrown);
                    }
                  }
                );
              }
            );";
          }
        }
      ?>
    }
  );
</script>
</html>