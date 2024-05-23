<?php 

    $corner_image = "images/user_male.jpg";
    if(isset($USER)){ 
        
        if(file_exists($USER['profile_image']))
        {
          $image_class = new Image();
          $corner_image = $image_class->get_thumb_profile($USER['profile_image']);
        }else{
           
            if($USER['gender'] == "Female"){
            
            $corner_image = "images/user_male.jpg";  
            }
        }
     }
?>

<div id="footer_bar">
    <div style="width: 50%; margin: auto; padding-top: 15px;">
        <a href="index.php" style="color:white; text-decoration: none; text-shadow: 1px 1px 2px #161616, 0 0 25px white, 0 0 5px #a1ff44;font-size:32px;">Star</a>
        <div style="float: right;padding-top: 20px;color:white;">

            <a href="profile.php">
                <img src="<?php echo $corner_image ?>" style="width: 50px; float: left; margin: 10px; border-radius: 5px;">
            </a>

           <div style="color:white; text-decoration: none; text-shadow: 1px 1px 2px #161616, 0 0 25px white, 0 0 5px #a1ff44;"> <?php echo $USER['first_name'] . " " . $USER['last_name']?>
            <br></div>
            <?php echo $USER['title'] ?><br>
            <a href="logout.php" style="font-size:16px;color:white;text-decoration: none;">
                Logout
            </a>
        </div>
        <br>
        <a href="terms_and_conditions.php" style="font-size: 18px; color: white;text-decoration: none;">Terms and conditions</a><br>
        <a href="privacy_policy.php" style="font-size: 18px; color: white;text-decoration: none;">Privacy policy</a><br>
        <a href="help_and_support.php" style="font-size: 18px; color: white;text-decoration: none;">Help & support</a><br>
        <a href="report_a_problem.php" style="font-size: 18px; color: white;text-decoration: none;">Report a problem</a><br>

    </div>
</div>
