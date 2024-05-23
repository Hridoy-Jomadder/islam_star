<?php 

    include("classes/autoload.php");
    $ERROR = "";

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

    $msg_class = new Messages();
    //new message//check if thead already exists
    if(isset($_GET['id']) && $_GET['id'] == "new"){

    $old_thread = $msg_class->read($_GET['id']);
        
        if(is_array($old_thread)){
        
            //redirect the user
            header("Location: message.php/read/.$_GET('userid')");
          die;
        }
    }
      //if a message was posted
    if($ERROR == "" && $_SERVER['REQUEST_METHOD'] == "POST"){
        
    $user_class = new $User();    
    if(is_array($user_class->get_user($_GET('userid')))){
              
         $msg_class = new Messages();
         $ERROR = $msg_class->send($_POST,$_FILES,$_GET('userid'));
          
       header("Location: message.php/read/.$_GET('userid')");
          die;
      }else{
          $ERROR == "The requested user could not be found!";
    }  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Star</title>
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
            background-image: url(img/search.png);
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
            background-color: #405d9b;
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

        #message_left {
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin: 8px;
            width: 60%;
            float: left;
            border-radius: 10px;
        }

        #message_thread {
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin: 8px;
            width: 60%;
            float: left;
            border-radius: 10px;
        }

        #message_thread {
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin: 8px;
            border-radius: 10px;
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


                    <form method="post" enctype="multipart/form-data">

                        <?php
                  
                         if($ERROR != ""){
              
                           echo $ERROR;
                          }else{
                         
                            if(isset($_GET['id']) && $_GET['id'] == "read"){
                                
                            echo "Chatting With:<br><br>";
                            
                            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                                
                                $data = $msg_class->read($_GET['id']);

                                $user = new User();
                                var_dump($FRIEND_USER);
                                //$_GET['id'] isset copy get_user 
                                $FRIEND_USER = $user->get_user($ROW['userid']);           
                                include "user.php";
                                
                                echo"<a href='messages'>";
                                echo'<input id="post_button" type="button" style="width:auto;cursor:pointer;margin:4px;" value="All Messages">';
                                echo"</a>";
                                
                                if(is_array($data)){
                                    echo"<a href='" ('thread.php') . $data[0]['msgid'] ."'>";
                                    echo'<input id="post_button" type="button" style="width:auto;cursor:pointer;background-color:red;margin:4px;" value="Delete Thread">';
                                    echo"</a>";
                                }
                                echo '
                                <div>';
                                
                                $user = new User();
                                
                                if(is_array($data)){
                                
                                foreach ($data as $MESSAGE){
                                    #code...
                                             // show($MESSAGE);
                                              $ROW_USER = $user->get_user($MESSAGE['sender']);

                                              if(i_own_content($MESSAGE)){

                                              include "message_right.php";
                                              }else{

                                              include "message_left.php";
                                              }
                                            }
                                        }
                                echo '    
                                </div>';
                                
                                echo '
                                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                                       <textarea name="message" placeholder=" Write your message here "></textarea>
                                       <input type="file" name="file">
                                       <input type="hidden" name="msgid" value='.$data[0]['msgid'];'>
                                       <input id="post_button" type="submit" value="Send">
                                       <br>
                                   <br>
                               </div> 
                               ';
                            }else{
                                    
                                echo "That user could not be found<br><br>";
                                }
                                
                            if(isset($_GET['id']) && $_GET['id'] == "new"){

                              echo "Start New Message with:<br><br>";
                               
                            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                                  
                                $user = new User();
                                //$_GET['id'] isset copy get_user 
                                $FRIEND_USER = $user->get_user($ROW['userid']);
                               
                                include "user.php";
                                    echo '
                                    <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                                           <textarea name="message" placeholder=" Write your message here "></textarea>
                                           <input type="file" name="file">
                                           <input id="post_button" type="submit" value="Send">
                                           <br>
                                       <br>
                                   </div> ';
                              }else{
                                    
                                echo "That user could not be found<br><br>";
                                }
                                
                          }else{

                            echo "Messages<br><br>";
                            $data = $msg_class->read_threads();
                            $user = new User();
                            $me = esc($_SESSION['star_userid']);
                                
                            if(is_array($data)){
                             foreach($data as $MESSAGE){
                                 #code...
                                 
                                 $myid = ($MESSAGE['sender'] == $me) ? $MESSAGE['receiver'] : $MESSAGE['sender'];
                                 $ROW_USER = $user->get_user($myid);
                                 
                                 include("thread.php");
                                 }
                            }else{
                            
                            echo "You have no messages!";
                            }
                             echo "<br style='clear:both;'> ";
                           }
                          }
                         }
                      ?>
                        <br>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
