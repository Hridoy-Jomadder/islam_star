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
	$User = new User();
 	$image_class = new Image();

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>Notifications | Star</title>
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

    #notification {

        height: 50px;
        background-color: #eee;
        color: #666;
        border: 1px solid #aaa;
        margin: 4px;
    }

</style>

<body style="font-family: times new roman; background-color: #d0d8e4;">

    <!-- header-->
    <?php include("header.php"); ?>

    <!--cover area-->
    <div style="width: 800px;margin:auto;min-height: 400px;">

        <!--  below  cover area-->
        <div style="display: flex;">
            <!--    Notification area-->
            <div style="min-height: 400px; flex: 2.5; padding: 40px; padding-left: 0px;">
                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">

                    <?php
                    
                    $DB = new Database();
                    $id = esc($_SESSION['star_userid']);
                    $follow = array();
                
 							//check content i follow
 							$sql = "select * from content_i_follow where disabled = 0 && userid = '$id' limit 100";
 							$i_follow = $DB->read($sql);
 							if(is_array($i_follow)){
 								$follow = array_column($i_follow, "contentid");
 							}

 							if(count($follow) > 0){

 								$str = "'" . implode("','", $follow) . "'";
   								$query = "select * from notifications where (userid != '$id' && content_owner = '$id') || (contentid in ($str)) order by id desc limit 30";
 							}else{

  								$query = "select * from notifications where userid != '$id' && content_owner = '$id' order by id desc limit 30";
 							}
 
 							$data = $DB->read($query);
 						?>

                    <?php if(is_array($data)): ?>

                    <?php foreach ($data as $notif_row): 
 							 
 						include("single_notification.php");
  					 	
                        endforeach; ?>
                    <?php else: ?>
                    No notifications were found
                    <?php endif; ?>


                </div>

            </div>
        </div>
    </div>
</body>

</html>
