 <?php 

  include"classes/autoload.php";


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

  //posting stars here
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {      
      
      include"change_image.php";  //()
      
     if(isset($_POST['first_name'])){
          
          $settings_class = new Settings();
          $settings_class->save_settings($_POST,$_SESSION['star_userid']);
          
    }else{
          
      $post = new Post();
      $id = $_SESSION['star_userid'];
      $result = $post->create_post($id,$_POST,$_FILES);
      
        if($result == "")
         {
            header("Location: index.php");
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

	//check if this is from a notification
	if(isset($_GET['notif'])){
		notification_seen($_GET['notif']);
	}

   //forgot password
    $password = ('$password'); //Add new line
//	$password = password_hash($password, PASSWORD_DEFAULT);
	$query = "update users set password = '$password' ";

//IP and Browser Code
function get_client_ip() {
    $ip_address = '';

    // Check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }
    // Check for IP passed from proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Check for IP address in REMOTE_ADDR
    elseif (!empty($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }

    return $ip_address;
}

function get_browser_name() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser_name = "Unknown";

    if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident/') !== false) {
        $browser_name = 'Internet Explorer';
    } elseif (strpos($user_agent, 'Edge') !== false) {
        $browser_name = 'Microsoft Edge';
    } elseif (strpos($user_agent, 'Firefox') !== false) {
        $browser_name = 'Mozilla Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        $browser_name = 'Google Chrome';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        $browser_name = 'Safari';
    } elseif (strpos($user_agent, 'Opera') !== false || strpos($user_agent, 'OPR/') !== false) {
        $browser_name = 'Opera';
    } elseif (strpos($user_agent, 'Brave') !== false) {
        $browser_name = 'Brave';
    } elseif (strpos($user_agent, 'Edge') !== false) {
        $browser_name = 'Microsoft Edge';
    }

    return $browser_name;
}

// Example usage:
$ip_address = get_client_ip();
$browser_name = get_browser_name();

// echo "IP Address: " . $ip_address . "<br>";
// echo "Browser Name: " . $browser_name;
// echo "<br>";

//Country
function get_country_by_ip($ip) {
    $api_key = ''; // Replace with your actual API key
    $api_url = "http://ipinfo.io/{$ip}?token={$api_key}";

    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);

    // Check if the API request was successful and country information is available
    if (isset($data['country'])) {
        return $data['country'];
    } else {
        return "Unknown";
    }
}

// Example usage:
$ip_address = ""; // Replace with the actual IP address
$country = get_country_by_ip($ip_address);

//echo "Country: " . $country;

// Example usage:
$ip_address = get_client_ip();
$browser_name = get_browser_name();
$country = ""; // Assuming you obtain the country later in your code.

// Get user data (you can replace this with your own logic)
$login = new Login();
$user_data = $login->check_login($_SESSION['star_userid']);



// Ensure $user_data contains the expected keys
if (isset($user_data['userid'])) {
    // Example usage:
    $ip_address = get_client_ip();
    $browser_name = get_browser_name();
    $country = ""; // Placeholder for country (you may obtain this later in your code)

    // Check if the IP address is not empty before fetching country
    if (!empty($ip_address)) {
        $country = get_country_by_ip($ip_address);
    }

    // SQL to insert data into the database
 // Update user data in the database with the latest information
 $user_id = $user_data['userid']; // Assuming 'userid' is the primary key
 $sql = "UPDATE users 
         SET ip_address = '$ip_address', browser_name = '$browser_name', country = '$country' 
         WHERE userid = '$user_id'";
    // Instantiate the Database object
    $db = new Database();

    // Save data to the database
    $result = $db->save($sql);

    // if ($result) {
    //     echo "Data saved successfully.";
    // } else {
    //     echo "Error occurred while saving data to the database.";
    // }
}


?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Home | Star</title>
     <style>
         #blue_bar {
             height: 60px;
             background-color: #16b000;
             color: #d9dfeb;
             min-width: 505px;
         }

         #search_box {
            width: 30%;
            padding: 4px;
            font-size: 14px;
            /* background-image: url(images/search.png); */
            /* background-repeat: no-repeat; */
            background-position: right;
             font-family: times new roman;
         }

         #profile_pic {
             width: 10%;
             border: solid 2px greenyellow;
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
             width: 50px;
             cursor: pointer;
             box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
         }

         #post_bar {
             margin-top: 5px;
             background-color: white;
             padding: 30px;
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
             color: white;
             padding: 5px;
             font-size: 16px;
             cursor: pointer;
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

         /* Footer */
         #footer_bar {
             height: 200px;
             background-color: #16b000;
             color: #d9dfeb;
         }

     </style>
     <!-- icon -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
 </head>

 <body style=" background-color: #d0d8e4;">

          <!-- header-->
     <?php include"header.php"; ?>

     <!-- <div>
        <h2>Email Verification</h2>
        <?php if (is_array($errors) && count($errors) > 0): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form method="post">
            <label for="code">Enter Verification Code:</label><br>
            <input type="text" id="code" name="code" placeholder="Enter your code" required><br><br>
            <input type="submit" value="Verify">
        </form>
    </div> -->

     <!--cover area-->
     <div style="width: auto; margin: auto; min-height: 400px;">
         <div style="background-color: white; text-align: center; color: #405d9d; padding-bottom: 12px;">
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
             <img id="profile_pic" src="<?php echo $image ?>" style="width: 60px; float: left; margin:20px; border-radius: 10%;">
             <br>
             <div style="font-size: 20px;">

                 <a href="profile.php?id=<?php echo $user_data['userid']?>" style="text-decoration: none;">
                 <?php echo $user_data['first_name'] . " " . $user_data['last_name']?>
                                </a>
                 <br>
                 <small><?php echo $user_data['title'] ?></small>
             </div>

             <br>
                    <!-- <a href="index.php"><div id="menu_buttons"><i class="fa fa-users" style="color:green;"> Public </i></div></a> -->
                    <a href="profile.php?section=default&id=<?php echo $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user" style="color:green;"> Profile </i></div></a>
                    <a href="profile.php?section=about&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-edit" style="color:green;"> About </i></div></a>
                    <a href="profile.php?section=followers&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user-plus" style="color:green;"> Followers</i></div></a>
                    <a href="profile.php?section=following&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-user" style="color:green;"> Following</i></div></a>
                    <a href="profile.php?section=photos&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-image" style="color:green;"> Image</i></div></a>
                    <a href="profile.php?section=videos&id=<?php echo  $user_data['userid'] ?>"><div id="menu_buttons"><i class="fa fa-video" style="color:green;"> Videos</i></div></a>
         </div>

         <!--  below  cover area-->

         <!--    Post area-->
         <div style="min-height: 400px; flex: 2.5; ">

             <!--    posts -->
             <div id="post_bar">

                 <?php 
                      
                 $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                 $page_number = ($page_number < 1) ?  1 : $page_number;
                                        
                 $limit = 10;
                 $offset = ($page_number - 1) * $limit;
                    
                 $DB = new Database();
                 $user_class = new User();
                 $image_class = new Image();

                 $followers = $user_class->get_following($_SESSION['star_userid'],"user");

                 $follower_ids = false;
                 if(is_array($followers)){
                 
                  $follower_ids = array_column($followers, "userid");
                  $follower_ids = implode("','", $follower_ids);
                      
                 }
                 
                 if($follower_ids){  
                  $myuserid = $_SESSION['star_userid'];
                  $sql = "select * from posts where parent = 0 and (useid = '$myuserid' || userid in('" .$follower_ids. "')) order by id desc limit $limit offset $offset";
                  $posts =$DB->read($sql);
                 }

                if(isset($posts) && $posts)
                  {     
                      
                    foreach ($post as $ROW) {
                        # code....
                        
                        $user = new User();
                        $ROW_USER = $user->get_user($ROW['userid']);
                        
                        include"post.php";
                      }
                    }else{
                        echo"No post";
                    }
                    
                    //get current url
                    $pg = pagination_link();
                ?>

                 <a href="<?= $pg['next_page'] ?>">
                     <input id="post_button" type="button" value="Next Page" style="float:right; width:15%;font-family: times new roman;">
                 </a>
                 <a href="<?= $pg['previs_page'] ?>">
                     <input id="post_button" type="button" value="Previous page" style="float:left; width:15%;font-family: times new roman;">
                 </a>

             </div>

         </div>
     </div>
     <!--Footer-->
     <div style="">
         <?php include"footer.php"; ?>
     </div>

 </body>

 </html>
