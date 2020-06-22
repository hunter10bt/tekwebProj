<?php
  session_start();
  include "connectdb.php";
  if(!isset($_GET['id'])){
    header("location: index.php");
  }
  else {
    $franchiseID = $_GET["id"];
    $info = mysqli_query($con, "SELECT `Franchise Name`, `Summary` FROM franchise WHERE franchiseIDName='$franchiseID' AND readable=1");

    $row = mysqli_fetch_array($info);
    if($row == null){
      header("location: index.php");
    }
    else {    
      $name = $row[0];
      $summary = $row[1];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<script src="jquery-3.5.1.js"></script>
<!-- <script src="popper.min.js"></script>
<script src="bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Franchise - ReadHere</title>
  <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
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
            echo "<a class='nav-link' href='signin.php?prevPage=franchise.php?id=$franchiseID'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=franchise.php?id=$franchiseID'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=franchise.php?id=$franchiseID'>Sign Out</a>";
            echo '</li>';
          }
        ?>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container-fluid"id="container">
    <div class="row">
      <div class="col-xl-10" style="padding-left: 2.5%; padding-right: 2.5%;">
        <div class="row">
          <div class="tab-content" id="nav-tabContent" style="width: max-content; ">
            <div class="tab-pane fade show active" id="list-about" role="tabpanel" aria-labelledby="list-about-list">
              <?php
                echo "<h1>$name</h1>";
                echo "$summary";
              ?>
            </div>
            <div class="tab-pane fade" id="list-story" role="tabpanel" aria-labelledby="list-story-list">
              <h2>List of Stories</h2>
              <div class="list-group" id="story-list">
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
      <div class="col-xl-2">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-about-list" data-toggle="list" href="#list-about" role="tab" aria-controls="about">About</a>          
          <?php
            echo "<a class='list-group-item list-group-item-action' id='list-story-list' data-toggle='list' href='#list-story' role='tab' aria-controls='story' franchiseID='$franchiseID'>List of Stories</a>";
            echo "<a class='list-group-item list-group-item-action' id='list-discussions-list' data-toggle='list' href='#list-discussions' role='tab' aria-controls='discussions' franchiseID= '$franchiseID'>List of Discussions</a>";
          ?>
        </div>
        <div class="list-group">
          <?php
            if (isset($_SESSION["uname"])) {
              # code...
              echo "<button type='button' class='list-group-item list-group-item-success' data-toggle='modal' data-target='#addDiscussionModal' franchiseID= '$franchiseID' id='trigger-new-discussion'>New Discussion</button>";
              echo "<button type='button' class='list-group-item list-group-item-success' data-toggle='modal' data-target='#addStoryModal'franchiseID= '$franchiseID' id='trigger-new-story'>New Story</button>";
            }
          ?>
        </div>
        <div class="modal fade" id="addDiscussionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Discussion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="discussionTitleInput">Discussion Title</label>
                  <input type="text" class="form-control" name="discussionTitleInput" id="discussionTitleInput" aria-describedby="discussionTitleHelp" placeholder="Insert title here..." maxlength="64">
                  <small id="discussionTitleHelp" class="form-text text-muted">Inser discussion title here</small>
                </div>
                <div class="form-group">
                  <label for="discussionDetailsInput">Details</label>
                  <textarea class="form-control" name="discussionDetailsInput" id="discussionDetailsInput" rows="5" maxlength="256"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="adddiscussion" data-dismiss="modal">Add Discussion</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="addStoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Story</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="storyTitleInput">Story Title</label>
                  <input type="text" class="form-control" name="storyTitleInput" id="storyTitleInput" placeholder="Insert title here..." maxlength="32">
                </div>
                <div class="form-group">
                  <label for="summaryInput">Summary</label>
                  <textarea class="form-control" name="summaryInput" id="summaryInput" rows="5" maxlength="256"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addStory"  data-dismiss="modal">Add Story</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
<script type="text/javascript">
  function loadStoryList(){
    var v_id = $("#list-story-list").attr('franchiseid');
    $.ajax(
      {
        url : "loadStoryList.php",
        type : "POST",
        async : true,
        data : {
          id : v_id,
          updateStoryList : true,
        },
        success : function(result){
          $("#story-list").html(result);
        },
        error: function(jqXHR, status, errorThrown){
          $('#story-list').html(errorThrown);
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  function loadDiscussionList(){
    var v_id = $("#list-discussions-list").attr('franchiseid');
    $.ajax(
      {
        url : "loadDiscussionList.php",
        type : "POST",
        async : true,
        data : {
          franchiseID : v_id,
          updateDiscussionList : true,
        },
        success : function(result){
          $("#discussion-list").html(result);
        },
        error: function(jqXHR, status, errorThrown){
          $('#discussion-list').html(errorThrown);
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  $(function(){
    loadDiscussionList();
    loadStoryList();

    $("#list-story-list").click(
      function(){
        loadStoryList();
      }
    );
    
    $("#list-discussions-list").click(
      function(){
        loadDiscussionList();
      }
    );

    $('#addStory').click(
      function(){
        var title = $('#storyTitleInput').val();
        var details = $('#summaryInput').val();
        var initiator = $('#unameDisplay').text();
        var franchiseID = $('#trigger-new-discussion').attr('franchiseID');
        $("#storyTitleInput").val('');
        $("#summaryInput").val('');

        $.ajax(
          {
            url: 'addStory.php',
            type: 'POST',
            async: true,
            data: {
              title: title,
              details: details,
              franchiseID: franchiseID,
              newStory: true,
            },
            success: function(show){
              alert(show);
              console.log(show);
            },
            error: function(jqXHR, status, errorThrown){
              alert(errorThrown);
              console.log(errorThrown);
            }
          }
        );
      }
    );

    $('#adddiscussion').click(
      function(){
        var title = $('#discussionTitleInput').val();
        var details = $('#discussionDetailsInput').val();
        var initiator = $('#unameDisplay').text();
        var franchiseID = $('#trigger-new-discussion').attr('franchiseID');
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
              franchiseID: franchiseID,
              newDiscussion: true,
            },
            success: function(show){
              alert(show);
              console.log(show);
            },
            error: function(jqXHR, status, errorThrown){
              alert(errorThrown);
              console.log(errorThrown);
            }
          }
        );
      }
    );
  });
</script>
</html>