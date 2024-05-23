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

// Check if there's a specific video ID in the URL
$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : null;
// Define the video URL corresponding to the video ID
$video_url = "http://localhost/Star/single_video.php?id=" . urlencode($video_id); // Ensure video ID is properly encoded

// Fetch videos 
// Assuming $videos is an array of video details fetched from the database
$videos = [
    [
        'title' => '',
        'description' => '',
        'tag' => '',
        'upload_date' => '',
        'video_url' => ''
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Post | Star</title>

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

</head>
<body style="font-family: times new roman; background-color: #d0d8e4;">
    <!-- header-->
    <?php include("header.php"); ?>

    <!-- cover area -->
    <div style="width: 1504px; margin: auto; min-height: 400px;">
        <div style="background-color: white; text-align: left; color: #405d9d">
            <!-- below cover area -->
            <div style="display: flex;">
                <!-- Post area -->
                <div style="min-height: 400px; flex: 2.5; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom: 10px;">
                    <div style="border: solid thin #aaa; padding: 28px; background-color: white;">
                        <!-- Display video -->
                        <video controls style="width: 100%;">
                            <!-- Set the source of the video dynamically -->
                            <source src="<?php echo $video_url; ?>" type="video/mp4">
                            <!-- Add more source elements for different video formats if needed -->
                            Your browser does not support the video tag.
                        </video>

                        <?php
                        // Loop through the videos and display details
                        foreach ($videos as $video) {
                            echo "<div>";
                            echo "<h2>{$video['title']}</h2>";
                            echo "<p>{$video['description']}</p>";
                            echo "<p>Tag: {$video['tag']}</p>";
                            echo "<p>Uploaded on: {$video['upload_date']}</p>";
                            echo "<video controls>";
                            echo "<source src='{$video['video_url']}' type='video/mp4'>";
                            echo "Your browser does not support the video tag.";
                            echo "</video>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

