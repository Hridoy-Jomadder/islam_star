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

  $Post = new Post();
  $msg_class = new Messages();

    if(isset($_SERVER['HTTP-REFERER']) && !strstr($_SERVER['HTTP-REFERER'], "delete.php")){

              $_SESSION['return_to'] = $_SERVER['HTTP-REFERER'];
    }

    $ERROR = "";
    if(isset($_GET['id'])){
        
        if($_GET['id'] == "msg")
        {
            $MESSAGE = $msg_class->read_one($_GET['id']);

            if(!$MESSAGE){

              $ERROR = "Accesss denied! you cant delete this message!";
            }
        }else
        if($_GET['id'] == "thread")
        {
            $MESSAGE = false;
            
            if(isset($_GET['id'])){
               $MESSAGE = $msg_class->read_one_thread($_GET['id']);
            }
            if(!$MESSAGE){

              $ERROR = "Accesss denied! you cant delete this thread!";
            }
            
        }else{

            $ROW = $Post->get_one_post($_GET['id']);

            if(!$ROW){

              $ERROR = "No such post was found!";
            }else{

                if(!i_own_content($ROW)){

                   $ERROR = "Accesss denied! you cant delete this file!";
               }
            }
      }
        
       }else{

          $ERROR = "No such post was found!";
       }

      //if something was posted
    if($ERROR == "" && $_SERVER['REQUEST_METHOD'] == "POST"){

     if($_GET['id'] == "msg")
        {
            
           $msg_class->delete_one($_POST['id']);
     }else{
          
          $Post->delete_post($_POST['postid']);
          
      } 
      //.$_SESSION['$return_to']
        header("Location: profile.php");
          die;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete | Star</title>
    <style>
        #blue_bar {
            height: 60px;
            background-color: #16b000;
            color: #d9dfeb;
        }

        #search_box {
            width: 40%;
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

        #textarea {
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

    </style>
</head>

<body style="font-family: times new roman; background-color: #d0d8e4;">

    <!-- header-->
    <?php include("header.php"); ?>

    <!--cover area-->
    <div style="width: 1200px;margin:auto;min-height: 400px;">

        <!--  below  cover area-->
        <div style="display: flex;">

            <!--    Post area-->
            <div style="min-height: 400px;flex: 2.5;padding: 40px;padding-left: 0px;">

                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">

                <form method="post">
                        <?php

                         if($ERROR != ""){

                            echo $ERROR;
                        }else{

                            if(isset($_GET['id']) && $_GET['id'] == "msg")
                            { 
                                echo "Are you sure you want to delete this message?<br>";

                                $user = new User();
                                $ROW_USER = $user->get_user($MESSAGE['sender']);

                                include("message_left.php");

                                echo "<input type='hidden' name='id' value='$MESSAGE[id]'>";
                                echo "<input id='post_button' type='submit' value='Delete'>";

                             }else
                            if(isset($_GET['id']) && $_GET['id'] == "thread")
                            { 
                                echo "Are you sure you want to delete this thread?<br>";

                                $user = new User();
                                $ROW_USER = $user->get_user($MESSAGE['sender']);

                                include("message_left.php");

                                echo "<input type='hidden' name='id' value='$MESSAGE[msgid]'>";
                                echo "<input id='post_button' type='submit' value='Delete'>";

                             }else{

                                echo "Are you sure you want to delete this post?<br>";

                                $user = new User();
                                $ROW_USER = $user->get_user($ROW['userid']);

                                include("post_delete.php");

                                echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
                                echo "<input id='post_button' type='submit' value='Delete'>";

                            }
                         }
                      ?>
                        <br style="clear: both;">
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
