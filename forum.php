<?php
  session_start();
  include "connectdb.php";
  if(!isset($_GET["id"])){
    header("location: index.php");
  }
  $query = "SELECT title, user, content, dateCreated FROM discussion WHERE discussionID={$_GET["id"]} AND readable = 1";
  $result = mysqli_query($con, $query);

  if(!$result){
    header("location: index.php");
  }
  else {
    $row = mysqli_fetch_array($result);

    $id=$_GET["id"];
    $title=$row[0];
    $user=$row[1];
    $content=$row[2];
    $date=$row[3];
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
  <title>Forum - ReadHere</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-xl navbar-light bg-light navbar-fixed-top" id="navbar">
    <a class="navbar-brand" href="index.php">ReadHere</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <?php
          if(!isset($_SESSION["uname"])){
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signin.php?prevPage=forum.php?id=$id'>Sign In</a>";
            echo '</li>';
            
            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signup.php?prevPage=forum.php?id=$id'>Sign Up</a>";
            echo '</li>';
          }
          else {
            echo '<li class="nav-item">';
            echo "<a class='nav-link disabled' href='#' tabindex='-1' aria-disabled='true'>{$_SESSION['uname']}</a>";
            echo '</li>';

            echo '<li class="nav-item">';
            echo "<a class='nav-link' href='signout.php?prevPage=forum.php?id=$id'>Sign Out</a>";
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
        <div class="jumbotron jumbotron-fluid">
          <div class="container">
            <h1 class="display-3">
              <?php echo $title; ?>
            </h1>
            <p class="lead">By <?php echo $user; ?></p>
            <hr class="my-2">
            <p><?php echo $content; ?></p>
          </div>
        </div>
        <div id="commentList"></div>
      </div>
      <div class="col-xl-2" style="word-wrap: break-word;">
        <h1><?php echo $title; ?></h1>
        <p>By <?php echo $user; ?></p>
        <p><?php echo $content; ?></p>
        <?php
          if (isset($_SESSION["uname"])) {
            echo "<div class='list-group'>";
            echo "<button class='list-group-item list-group-item-success btn-add-comment' targettype='discussion' targetDiscussionID='$id' id='addCommentToDiscussion' data-toggle='modal' data-target='#addCommentModal'>Add Comment</button>";
            echo "<button class='list-group-item list-group-item-danger btn-report' targettype='discussion' targetDiscussionID='$id' id='reportDiscussion' data-toggle='modal' data-target='#reportModal'>Report</button>";
            echo "</div>";
          }
        ?>        
        <!-- Add Comment Modal -->
        <div class='modal fade' id='addCommentModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Add Comment</h5>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                  </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <div class='form-group'>
                    <label for='commentInput'>Comment:</label>
                    <textarea class='form-control' name='commentInput' id='commentInput' rows='5'></textarea>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-primary' data-dismiss='modal' targettype='' targetDiscussionID='' targetcommentid='' id='modalComment'>Add Comment</button>
              </div>
            </div>
          </div>
        </div>

        
        <!-- Report Modal -->
        <div class='modal fade' id='reportModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Report</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <div class='form-group'>
                    <label for='reportTitleInput'>Report Title</label>
                    <input type='text' class='form-control' name='reportTitleInput' id='reportTitleInput' placeholder='Insert report title here...'>
                  </div>
                  <div class='form-group'>
                    <label for='detailInput'>Detail:</label>
                    <textarea class='form-control' name='detailInput' id='detailInput' rows='5'></textarea>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-primary' data-dismiss='modal' targettype='' targetDiscussionID='' targetcommentid='' id='modalReport'>Report</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Edit comment modal implemented soon-->
        <div class='modal fade' id='editCommentModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Edit Comment</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <div class='form-group'>
                    <label for='editCommentInput'>Edit Comment:</label>
                    <textarea class='form-control' name='editCommentInput' id='editCommentInput' rows='5'></textarea>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-success' data-dismiss='modal' targetcommentid='' id='modalEditComment'>Edit Comment</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Delete comment modal implemented soon -->
        <div class='modal fade' id='deleteCommentModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Delete Comment</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <p>Do you want to delete this comment?</p>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-primary' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-primary' data-dismiss='modal' targetcommentid='' id='modalDeleteComment'>Delete Comment</button>
              </div>
            </div>
          </div>
        </div>

        <!-- edit discussion modal implemented soon-->
        <div class='modal fade' id='editDiscussionModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Report</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <div class='form-group'>
                    <label for='reportTitleInput'>Report Title</label>
                    <input type='text' class='form-control' name='reportTitleInput' id='reportTitleInput' placeholder='Insert report title here...'>
                  </div>
                  <div class='form-group'>
                    <label for='detailInput'>Detail:</label>
                    <textarea class='form-control' name='detailInput' id='detailInput' rows='5'></textarea>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-primary' data-dismiss='modal' targettype='' targetDiscussionID='' targetcommentid='' id="modalReport">Report</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Delete discussion modal implemented soon -->
        <div class='modal fade' id='deleteDiscussionModal' tabindex='-1' role='dialog' aria-labelledby='modelTitleId' aria-hidden='true'>
          <div class='modal-dialog' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h5 class='modal-title'>Report</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='container-fluid'>
                  <div class='form-group'>
                    <label for='reportTitleInput'>Report Title</label>
                    <input type='text' class='form-control' name='reportTitleInput' id='reportTitleInput' placeholder='Insert report title here...'>
                  </div>
                  <div class='form-group'>
                    <label for='detailInput'>Detail:</label>
                    <textarea class='form-control' name='detailInput' id='detailInput' rows='5'></textarea>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>
                <button type='button' class='btn btn-primary' data-dismiss='modal' targettype='' targetDiscussionID='' targetcommentid='' id="modalReport">Report</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script>
  function deleteComment(){
    var commentID = $('#modalDeleteComment').attr('targetcommentid');

    $.ajax(
      {
        url: "editComment.php",
        type: "POST",
        dataType: "html",
        data: {
          delete: true,
          commentID: commentID,
        },
        success: function(result){
          check = JSON.parse(result);
          alert(check.message);
          loadComments();
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(errorThrown);
        }
      }
    );    
  }

  function editComment() {
    var commentID = $('#modalEditComment').attr('targetcommentid');
    var comment = $('#editCommentInput').val();
    $.ajax(
      {
        url: "editComment.php",
        type: "POST",
        dataType: "html",
        data: {
          edit: true,
          commentID: commentID,
          comment: comment,
        },
        success: function(result){
          check = JSON.parse(result);
          alert(check.message);
          loadComments();
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(errorThrown);
          console.log(errorThrown);
        }
      }
    );
  }

  function loadComments() {
    //Trigger ajax script here
    var targetDiscussionID = <?php echo $id; ?>;
    $.ajax(
      {
        url: "loadCommentList.php",
        type: "POST",
        data: {
          loadComment: true,
          discussionID: targetDiscussionID
        },
        success: function (result) {
          $("#commentList").html(result);
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(errorThrown);
        }
      }
    )
  }

  function addComment(){
    var targettype = $("#modalComment").attr('targettype');
    var targetDiscussionID = $("#modalComment").attr('targetDiscussionID');
    var targetcommentid = $("#modalComment").attr('targetcommentid');
    var comment = $("#commentInput").val();
    alert("Target type: "+targettype);
    alert("Target discussion ID: "+targetDiscussionID);
    alert("Target comment ID: "+targetcommentid);
    alert("Comment: "+comment);

    $.ajax(
      {
        url: "addComment.php",
        type: "POST",
        data: {
          addComment: true,
          targetType: targettype,
          targetcommentid: targetcommentid,
          targetDiscussionID: targetDiscussionID,
          comment: comment
        },
        success: function(result){
          alert(result);
          loadComments();
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(errorThrown);
        }
      }
    );
    $("#commentInput").val('');
  }

  function report(){
    var title=$("#reportTitleInput").val();
    var details=$("#detailInput").val();
    $("#detailInput").val('');
    $("#reportTitleInput").val('');
    var targettype=$("#modalReport").attr('targettype');
    var targetDiscussionID=$("#modalReport").attr('targetDiscussionID');
    var targetcommentid=$("#modalReport").attr('targetcommentid');

    $.ajax(
      {
        url: "addReport.php",
        type: "POST",
        data: {
          addReport:true,
          title:title,
          targettype:targettype,
          targetcommentid:targetcommentid,
          targetDiscussionID:targetDiscussionID,
          details: details
        },
        success: function(result) {
          alert(result);
        },
        error: function(jqXHR, textStatus, errorThrown){
          alert(errorThrown);
        }
      }
    );
  }

  $(document).ready(
    function(){
      loadComments();
      $("body").delegate(
        ".btn-add-comment",
        "click",
        function(){
          $('#modalComment').attr('targettype', $(this).attr('targettype'));
          alert($('#modalComment').attr('targettype'));
          $('#modalComment').attr('targetcommentid', $(this).attr('targetcommentid'));
          alert($('#modalComment').attr('targetcommentid'));
          $('#modalComment').attr('targetDiscussionID', $(this).attr('targetDiscussionID'));  
          alert($('#modalComment').attr('targetDiscussionID'));
        }
      );

      $("body").delegate(
        ".btn-report",
        "click",
        function(){
          $('#modalReport').attr('targettype', $(this).attr('targettype'));
          alert($('#modalReport').attr('targettype'));
          $('#modalReport').attr('targetcommentid', $(this).attr('targetcommentid'));
          alert($('#modalReport').attr('targetcommentid'));
          $('#modalReport').attr('targetDiscussionID', $(this).attr('targetDiscussionID'));  
          alert($('#modalReport').attr('targetDiscussionID'));
        }
      );

      $('body').delegate(
        '.btn-edit-comment',
        'click',
        function(){
          $('#modalEditComment').attr(
            'targetcommentid', $(this).attr('targetcommentid')
          );
        }
      );

      $('body').delegate(
        '.btn-delete-comment',
        'click',
        function(){
          $('#modalDeleteComment').attr(
            'targetcommentid',
            $(this).attr('targetcommentid')
          );
        }
      );

      $('#modalEditComment').click(
        function(){
          editComment();
        }
      );

      $('#modalDeleteComment').click(
        function(){
          deleteComment();
        }
      );

      $("#modalComment").click(
        function(){
          addComment();
        }
      );

      $("#modalReport").click(
        function() {
          report();
        }
      );
    }
  );
</script>
</html>