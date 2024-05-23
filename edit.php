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

    $ERROR = "";
    if(isset($_GET['id'])){

        $ROW = $Post->get_one_post($_GET['id']);

        if(!$ROW){

          $ERROR = "No such post was found!";
        }else{

            if($ROW['userid'] != $_SESSION['star_userid']){

            $ERROR = "Accesss denied! you cant delete this file!";
         }
        }
       }else{

        $ERROR = "No such post was found!";
       }

    if(isset($_SERVER['HTTP-REFERER']) && !strstr($_SERVER['HTTP-REFERER'], "edit.php")){

              $_SESSION['return_to'] = $_SERVER['HTTP-REFERER'];
          }

      //If something was posted
      if($_SERVER['REQUEST_METHOD'] == "POST"){

          $Post->edit_post($_POST,$_FILES);

          header("Location: ".$_SESSION['$return_to']);
          die;
      }  
  
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <head>
    <title>Edit | Star</title>
    </head>
    <style type="text/css">
        #blue_bar {
            height: 60px;
            background-color: #405d9b;
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

<body style="font-family: times new roman; background-color: #d0d8e4;">

    <!-- header-->
    <?php include("header.php"); ?>

    <!--cover area-->
    <div style="width: 1300px;margin: auto;min-height: 400px;">
        
        <!--  below  cover area-->
        <div style="display: flex;">
           
            <!--    Post area-->
            <div style="min-height: 400px; flex: 2.5; padding: 40px; padding-left: 0px;">
                
                   <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                    <h2>Edit post</h2><br>
                    <form method="post" enctype="multipart/form-data">

                    <?php
                  
                    if($ERROR != ""){
              
                        echo $ERROR;
                      }else{
                       
                        
                        echo '<textarea name="post" placeholder="Do you start?" style="height: 200px;">'.$ROW['post'].'</textarea>
                              <input type="file" name="file">  ';
                        
                        echo "<input type='hidden' name='postid'  value='$ROW[postid]'>";
                        echo "<input id='post_button' type='submit' value='Save' style='font-family: times new roman;'>";
                        
                        
                         if(file_exists($ROW['image']))
                         {
                            $image_class = new Image();
                            $post_image = $image_class->get_thumb_post($ROW['image']);

                            echo " <br><br> <div style='text-align:center;'><img src='$post_image' style='width:100%;'/></div>";
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
