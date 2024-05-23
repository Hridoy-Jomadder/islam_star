<?php 

  include("classes/autoload.php");

  $login = new Login();
  $user_data = $login->check_login($_SESSION['star_userid']);
  
  $USER = $user_data;

  if(isset($_GET['id']) && is_numeric($_GET['id'])){
  
      $profile = new Profile();
      $profile_data = $profile->get_profile($_GET['id']);

      if(is_array($profile_data)){
          $user_data = $profile_data[0];
      }
  }

  //posting starts here
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
      $post = new Post();
      $id = $_SESSION['star_userid'];
      $result = $post->create_post($id, $_POST, $_FILES);

      if($result == "")
      {
          header("Location: single_post.php?id=".$_POST['parent']);
          die;
      }
      else
      {
          echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
          echo "<br>The following errors occured:<br><br>";
          echo $result;
          echo "</div>";
      }
  }

  $Post = new Post();
  $ROW = false;

  $ERROR = "";
  if(isset($_GET['id'])){
      $ROW = $Post->get_one_post($_GET['id']);
  }else{
      $ERROR = "No Post was found!";
  }

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>Single Post | Star</title>
</head>
<style>
    #blue_bar {
        height: 60px;
        background-color: #16b000;
        color: #d9dfeb;
    }

    #search_box {
        width: 400px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url(images/search.png);
        background-repeat: no-repeat;
        background-position: right;
    }

    #profile_pic {
        width: 300px;
        margin-top: -320px;
        border: solid 5px red;
    }

    #menu_buttons {
        width: 100px;
        display: inline-block;
        margin: 2px;
    }

    #menu_buttons a {
        text-decoration: none;
    }

    #friends_img {
        width: 70px;
        float: left;
        margin: 8px;
    }

    #friends_bar {
        background-color: #ffffff;
        min-height: 400px;
        margin-top: 20px;
        color: black;
        text-align: center;
    }

    #friends {
        clear: both;
        font-size: 12px;
        font-weight: bold;
        color: #405d9b;
        padding: 8px;
    }

    textarea {
        width: 100%;
        border: none;
        font-family: times new roman;
        font-size: 14px;
        height: 50px;
    }

    #post_button {
        float: right;
        background-color: #16b000;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    #post_bar {
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }

    #post {
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }

    #See_More {
        background-color: #405d9b;
        border: inset;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 18px;
        width: 82px;
        float: right;
    }

    /*Dropbtn*/
    .dropbtn {
        background-color: #4CAF50;
        /*             color: white;*/
        font-size: 20px;
        /*             border: 50%;*/
        cursor: pointer;
        width: 50%;
        padding-right: 18px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: -26px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }

</style>


<body style="font-family: times new roman; background-color: #d0d8e4;">
    <!-- header-->
    <?php include("header.php"); ?>

    <!--cover area-->
    <div style="width: 1504px; margin: auto; min-height: 400px;">
        <div style="background-color: white; text-align: left; color: #405d9d">

            <!--  below  cover area-->
            <div style="display: flex;">
                <!--    Post area-->
                <div style="min-height: 400px; flex: 2.5; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px;">
                    <div style="border: solid thin #aaa; padding: 28px; background-color: white;">
                        <?php 
                        
                        //check if this is from a notification
  					 		if(isset($_GET['notif'])){
  					 			notification_seen($_GET['notif']);
  					 		}
                     
                            $user = new User();
  					 		$image_class = new Image();

  					 		if(is_array($ROW)){

 	 					 		$ROW_USER = $user->get_user($ROW['userid']);
  					 			
  					 			if($ROW['parent'] == 0){
  					 				include("post.php");
  					 			}else{
  					 				$COMMENT = $ROW;
  					 				include("comment.php");
  					 			}
  					 		}
                     
                     ?>

                    <?php if($ROW['parent'] == 0): ?>

                        <br style="clear: both;">

                        <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                            <form method="post" enctype="multipart/form-data" action="single_post.php?id=<?php echo $ROW['postid']; ?>">

                                <textarea name="post" placeholder="Post a comment"></textarea>
                                <input type="hidden" name="parent" value="<?php echo $ROW['postid'] ?>"/> 
                                <input type="file" name="file" style="font-family: times new roman;">
                                <input id="post_button" type="submit" value="Post" style="font-family: times new roman;">
                                <br>
                            </form>
                        </div>

                        <?php else: ?>
                        <a href="single_post.php?id=<?php echo $ROW['parent'] ?>">
                            <input id="post_button" style="width:auto;float: left;cursor: pointer;" type="button" value="Back to main post" />
                        </a>
                        <?php endif; ?>
                        <br  style="clear: both;">

                        <?php 
 
 							$comments = $Post->get_comments($ROW['postid']);

 							if(is_array($comments)){

 								foreach ($comments as $COMMENT) {
 									# code...
 									$ROW_USER = $user->get_user($COMMENT['userid']);
 									include("comment.php");
 								}
 							}
                                
                               //get current url
                               $pg = pagination_link();
                              ?>

                       <?php if($ROW['parent'] == 0): ?>

                        <a href="<?= $pg['next_page'] ?>">
                            <input id="post_button" type="button" value="Next Page" style="float:right; width:150px; margin: 1px;">
                        </a>
                        <a href="<?= $pg['previs_page'] ?>">
                            <input id="post_button" type="button" value="Previous page" style="float:left; width:150px;margin: 1px;">
                        </a>

                       <?php endif; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>
