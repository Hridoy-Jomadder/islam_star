<?php 

    include("classes/autoload.php");

  $login = new Login();
  $_SESSION['star_userid'] = isset($_SESSION['star_userid']) ? $_SESSION['star_userid'] : 0;
  
  $user_data = $login->check_login($_SESSION['star_userid'],false);
  
  $USER = $user_data;

  if(isset($_GET['id']) && is_numeric($_GET['id'])){
  
      $profile = new Profile();
      $profile_data = $profile->get_profile($_GET['id']);

     if(is_array($profile_data)){
        $user_data = $profile_data[0];
     }
  }

  //posting stars here
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {      
      include("change_image.php");
      
     if(isset($_POST['first_name'])){
          
          $settings_class = new Settings();
          $settings_class->save_settings($_POST,$_SESSION['star_userid']);
          
    }else{
          
      $post = new Post();
      $id = $_SESSION['star_userid'];
      $result = $post->create_post($id, $_POST,$_FILES);
      
        if($result == "")
         {
            header("Location: profile.php");
            die;
         }else
         {
            echo "<div style='display:none;position:absolute; text-align:center;font-size:12px;color:white;background:red;'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
         }
    }
  }
  
	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
	
	$posts = $post->get_posts($id);

	//collect friends
	$user = new User();
 	
	$friends = $user->get_following($user_data['userid'],"user");

	$image_class = new Image();

   //collect friends part 2 
    $user = new User();
    $id = $user_data['userid'];
	$friends = $user->get_friends($id);
	$image_class = new Image();

	//check if this is from a notification
	if(isset($_GET['notif'])){
		notification_seen($_GET['notif']);
	}

?>
<!DOCTYPE html>

<html>
<html lang="bn">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>Star</title>
    <style>
        #bar {
            height: 100px;
            background-color: #16b000;
            color: #fff;
            padding: 4px;
            padding-right: 425px;
            border-radius: 4px;
        }

        #signup-button {
            background-color: #5bd043;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 30px;
            float: right;
        }

        #bar2 {
            background-color: #e9ebee;
            height: 2000px;
            margin-top: 10px;
            padding: 10px;

            font-weight: bold;
            border-radius: 4px;
        }

    </style>
</head>

<body style="font-family: times new roman; background-image: url(images/img.jpg);">
    <div id="bar">
        <div style="font-size: 40px;padding-left: 421px;" style="font-family: times new roman;">Star</div>
    </div>
    <div id="bar2">
        <div>
            <?php
                $image = "images/user_male.jpg";
               if($ROW_USER['gender'] == "Female")
               {
                   $image = "images/user_female.jpg"; 
                }
               if(file_exists($ROW_USER['profile_image']))
               {
                  $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);  
               }
        
             ?>

            <img src="<?php echo $image ?>" style='width: 50px; margin-right: 20px;border-radius: 50%;'>
        </div>
        <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
        <br>
        <!--                </a>-->
        <small><?php echo $user_data['title'] ?></small>
        <?php 

                        $mystars = "";      
                        if($user_data['stars'] > 0){

                              $mystars = "(" . $user_data['stars'] . " Followers)";
                            }
                    ?>
        <br>
        <tittle>Video Link</tittle>
        <p></p>
        <video src=""> </video>
    </div>
</body>

</html>
