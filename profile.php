<?php 

    include"classes/autoload.php";

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
      $result = $post->create_post($id,$_POST,$_FILES);
      
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

   //collect friends part 2 okay ai code lakbea public add new friends
//    $user = new User();
//    $id = $user_data['userid'];
// 	$friends = $user->get_friends($id);
// 	$image_class = new Image();

	//check if this is from a notification
	if(isset($_GET['notif'])){
		notification_seen($_GET['notif']);
	}


?>

<!DOCTYPE html>
<html lang="en">
<html lang="bn">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>Profile | Star</title>
</head>
<!--<link rel="stylesheet" href="boostrap/css/bootstrap.css" />-->
<style>
    #blue_bar {
        height: 60px;
        background-color: #16b000;
        color: #d9dfeb;
        min-width: 505px;
    }

    #search_box {
            width: 20%;
            padding: 4px;
            font-size: 14px;
            background-image: url(images/search.png);
            background-repeat: no-repeat;
            background-position: right;
    }

    #footer_bar {
        height: 200px;
        background-color: #16b000;
        color: #d9dfeb;
    }

    #textbox {
        width: 100%;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        border: solid thin grey;
        margin: 10px;
    }

    #profile_pic {
        width: 300px;
        margin-top: -320px;
        border: solid 2px greenyellow;
        margin-right: -310px;
        border-radius: 20px;
    }

    #menu_buttons {
        width: 100px;
        display:inline-block;
        margin: 5px;
        background-color: greenyellow;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        text-align: center;
        padding: 5px;
        border-radius: 5px;
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
        width: 130px;
        min-width: 50px;
        cursor: pointer;
        font-family: times new roman;
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
        background-color: #5bd043;
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

     <!-- icon -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!--nikosh css-->
<!--<link href='http://sonnetdp.github.io/nikosh/css/nikosh.css' rel='stylesheet' type='text/css'>-->


<body style="font-family: times new roman; background-color: #d0d8e4;">
    <div class="container">
        <div class="row">
            <!-- header-->
            <?php include("header.php"); ?>

            <!--change profile image area-->
            <div id="change_profile_image" style="display: none; position:absolute; width:100%; height:auto; background-color: #000000aa;">
                <div style="max-width:600px; margin:auto; min-height: 400px; flex: 2.5; padding: 40px; padding-left: 0px;">

                    <form method="post" action="profile.php?change=profile" enctype="multipart/form-data">
                        <div style="border:solid thin #aaa; padding: 10px; background-color: white;">
                            <input type="file" name="file" style="font-family: times new roman;"><br>
                            <input id="post_button" type="submit" style="width:120px;" value="Change">
                            <br>
                            <div style="text-align: center;">
                                <br>
                                <?php
                                      echo "<img src='$user_data[profile_image]' style='max-width:500px;'>";
                                ?>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>

            <!--change cover image area-->
            <div id="change_cover_image" style="display: none; position:absolute; width:100%; height:auto; background-color: #000000aa;">
                <div style="max-width: 600px; margin:auto; min-height: 400px; flex: 2.5; padding: 40px; padding-left: 0px;">

                    <form method="post" action="profile.php?change=cover" enctype="multipart/form-data">
                        <div style="border:solid thin #aaa; padding: 10px; background-color: white;">
                            <input type="file" name="file" style="font-family: times new roman;"><br>
                            <input id="post_button" type="submit" style="width:120px;" value="Change">
                            <br>
                            <div style="text-align: center;">
                                <br>
                                <?php
                                      echo "<img src='$user_data[cover_image]' style='max-width:500px;' >";
                                ?>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>

            <!--cover area-->
            <div style=" margin: auto; min-height: 400px;">
                <div style="background-color: white; text-align: center; color: #405d9d; padding-bottom: 10px;">
                  <?php  
            
                        $image = "images/cover_image.jpg";
                        if(file_exists($user_data['cover_image']))
                           {
                             $image = $image_class->get_thumb_cover($user_data['cover_image']);
                           }
                        ?>

                    <img src="<?php echo  $image ?>" style="width: 100%;">

                    <span style="font-size: 11px;">
                        <?php  
    
                        $image = "images/user_male.jpg";
                        if($user_data['gender'] == "Female")
                             {
                                 $image = "images/user_female.jpg";
                             }
                        if(file_exists($user_data['profile_image']))
                           {
                             $image =  $image_class->get_thumb_profile($user_data['profile_image']);
                           }
                        ?>
                        <img id="profile_pic" style="width: 22%;" src="<?php echo $image ?>"><br />

                        <?php if(i_own_content($user_data)) : ?>
                        
                        <a onclick="show_change_cover_image(event)" style="text-decoration: none;" href="change_profile_image.php?change=cover">Cover Image <img src="images/change_profile.svg" style="width:1%;
                        height: 1%;"></a>
                        |
                        <a onclick="show_change_profile_image(event)" style="text-decoration: none;" href="change_profile_image.php?change=profile">Change Profile Image <img src="images/change_profile.svg" style="width:1%;
                        height: 1%;"></a>
                        
                        <?php endif; ?>
                    </span>

                    <br>
                    <br>
                    <div style="font-size: 20px;color: black;">

                    <a href="profile.php?id=<?php echo $user_data['userid'] ?>" style="text-decoration: none;color: black;">
                        <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
                                <br>
                    </a>
                    <small><?php echo $user_data['title'] ?></small>
                        <?php 

                            $mystars = "";      
                            if($user_data['stars'] > 0){

                                $mystars = "(" . $user_data['stars'] . " Followers)";
                                }
                        ?>
                        <br>

                        <a href="star.php?type=user&id=<?php echo $user_data['userid']?>">
                            <input id="post_button" type="button" value="Follow<?php echo $mystars ?>" style="margin-right:10px;width:auto;">
                        </a>
                <?php
                 if($user_data['userid'] == $_SESSION['star_userid']): ?>

                        <a href="messages.php">
                            <input id="post_button" type="button" value="Messages" style="margin-right:10px;width:auto;">
                        </a>
                        <?php else: ?>
                        <!--               new/-->
                        <a href="messages.php?<?php $user_data['userid'] ?>">
                            <input id="post_button" type="button" value="Message" style="margin-right:10px;background-color: #9b409a;width:auto;">
                        </a>
                        <?php endif; ?>

                    </div>
                    <br><br>
                    <a href="index.php"><div id="menu_buttons"><i class="fa fa-users" style="color:green;"> Public </i></div></a>
                    <a href="profile.php?section=default&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user" style="color:green;"> Profile </i></div></a>
                    <a href="profile.php?section=about&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-edit" style="color:green;"> About </i></div></a>
                    <a href="profile.php?section=followers&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user-plus" style="color:green;"> Followers</i></div></a>
                    <a href="profile.php?section=following&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user" style="color:green;"> Following</i></div></a>
                    <a href="profile.php?section=photos&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-image" style="color:green;"> Image</i></div></a>
                    <a href="profile.php?section=videos&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-video" style="color:green;"> Videos</i></div></a>
      

                    <?php
                         if($user_data['userid'] == $_SESSION['star_userid']){

                         echo '<a href="profile.php?section=settings&id='.$user_data['userid'].'"><div id="menu_buttons"><i class="fa fa-setting" style="color:green;"> Settings </i></div></a>';

                         }
                     ?>
                </div>

                <!--below cover area-->
                <?php 
            
                    $section = "default";
                    if(isset($_GET['section'])){

                         $section = $_GET['section'];
                       }

                       if($section == "default"){

                     include("profile_content_default.php"); 

                    }elseif($section == "about"){

                     include("profile_content_about.php");   

                    }elseif($section == "following"){

                      include("profile_content_following.php");

                   }elseif($section == "followers"){

                     include("profile_content_followers.php");

                    }elseif($section == "photos"){

                      include("profile_content_photos.php"); 
                       
                    }elseif($section == "videos"){

                      include("profile_content_videos.php");

                    }elseif($section == "settings"){

                    include("profile_content_settings.php");

                    }
        
               ?>
                <br style="clear: both;">

            </div>

            <!--Footer-->
            <?php include("footer.php"); ?>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    function show_change_profile_image(event) {

        event.preventDefault();
        var profile_image = document.getElementById("change_profile_image");
        profile_image.style.display = "block";
    }


    function hide_change_profile_image() {

        var profile_image = document.getElementById("change_profile_image");
        profile_image.style.display = "none";
    }


    function show_change_cover_image(event) {

        event.preventDefault();
        var cover_image = document.getElementById("change_cover_image");
        cover_image.style.display = "block";
    }


    function hide_change_cover_image() {

        var cover_image = document.getElementById("change_cover_image");
        cover_image.style.display = "none";
    }


    window.onkeydown = function(key) {

        if (key.keyCode == 27) {

            //esc key was pressed
            hide_change_profile_image();
            hide_change_cover_image();
        }
    }

</script>