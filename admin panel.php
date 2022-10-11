<?php
session_start();

$connect = new PDO("mysql:host=localhost;dbname=social", "root", "");

function Count_notification($connect, $receiver_id)
{
 $query = "
 SELECT COUNT(notification_id) as total 
 FROM tbl_notification 
 WHERE notification_receiver_id = '".$receiver_id."' 
 AND read_notification = 'no'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  return $row["total"];
 }
}

function Load_notification($connect, $receiver_id)
{
 $query = "
 SELECT * FROM tbl_notification 
 WHERE notification_receiver_id = '".$receiver_id."' 
 ORDER BY notification_id DESC
 ";
 $statement = $connect->prepare($query);

 $statement->execute(); 

 $result = $statement->fetchAll();

 $total_row = $statement->rowCount();

 $output = '';

 if($total_row > 0)
 {
  foreach($result as $row)
  {
   $output .= '<li><a href="#">'.$row["notification_text"].'</a></li>';
  }
 }
 return $output;
}

function Get_user_name($connect, $user_id)
{
 $query = "
 SELECT username FROM tbl_twitter_user 
 WHERE user_id = '".$user_id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  return $row["username"];
 }
}

function count_retweet($connect, $post_id)
{
 $query = "
 SELECT * FROM tbl_repost 
 WHERE post_id = '".$post_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

function count_comment($connect, $post_id)
{
 $query = "
 SELECT * FROM tbl_comment 
 WHERE post_id = '".$post_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

function make_follow_button($connect, $sender_id, $receiver_id)
{
 $query = "
 SELECT * FROM tbl_follow 
 WHERE sender_id = '".$sender_id."' 
 AND receiver_id = '".$receiver_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $total_row = $statement->rowCount();
 $output = '';
 if($total_row > 0)
 {
  $output = '<button type="button" name="follow_button" class="btn btn-warning action_button" data-action="unfollow" data-sender_id="'.$sender_id.'"> Following</button>';
 }
 else
 {
  $output = '<button type="button" name="follow_button" class="btn btn-info action_button" data-action="follow" data-sender_id="'.$sender_id.'"><i class="glyphicon glyphicon-plus"></i> Follow</button>';
 }
 return $output;
}

function count_total_post_like($connect, $post_id)
{
 $query = "
 SELECT * FROM tbl_like 
 WHERE post_id = '".$post_id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 return $statement->rowCount();
}

function Get_user_id($connect, $username)
{
 $query = "
 SELECT user_id FROM tbl_twitter_user 
 WHERE username = '".$username."'
 "; 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["user_id"];
 }
}


?>


<html>  
    <head>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
        <style>

        .main_division
        {
            position: relative;
            width: 100%;
            height: auto;
            background-color: #FFF;
            border: 1px solid #CCC;
            border-radius: 3px;
        }
        #sub_division
        {
            width: 100%;
            height: auto;
            min-height: 80px;
            overflow: auto;
            padding:6px 24px 6px 12px;
        }
        .image_upload
        {
            position: absolute;
            top:0px;
            right:16px;
        }
        .image_upload > form > input
        {
            display: none;
        }

        .image_upload img
        {
            width: 24px;
            cursor: pointer;
        }

        </style>
    </head> 
  

    <body>  
        <div class="container">
   <?php
            include('menu.php');
            ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="panel-title">Powered by SPACES CO.</h3>
                                </div>
                                <div class="col-md-4">
                                    <div class="image_upload">
                                        <form id="uploadImage" method="post" action="upload.php">
                                            <label for="uploadFile"><img src="upload.png" /></label>
                                            <input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png, .mp4" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <form method="post" id="post_form">
                                <div class="form-group" id="dynamic_field">
                                    <textarea name="post_content" id="post_content" maxlength="160" class="form-control" placeholder="Write your short story"></textarea>
                                </div>
                                <div id="link_content"></div>
                                <div class="form-group" align="right">
                                    <input type="hidden" name="action" value="insert" />
                                    <input type="hidden" name="post_type" id="post_type" value="text" />
                                    <input type="submit" name="share_post" id="share_post" class="btn btn-primary" value="Share" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Your Timeline</h3>
                        </div>
                        <div class="panel-body">
                            <div id="post_list">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">User List</h3>
                        </div>
                        <div class="panel-body">
                            <div id="user_list"></div>
                        </div>
                    </div>
                </div>
            </div>
  </div>
            <a class = "a-default" href = "delete.php">Admin panel</a>
						<div class="admin-sub-heading">Logged in as <?php echo $_SESSION['username']; ?></div>
  
    </body>  
</html>

    <?php

    include('jquery.php');

    ?>

