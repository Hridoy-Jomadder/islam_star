<div id="friends" style="display: inline-block; width:328px; background-color: #eee; margin: 5px;">
    <?php 
        $image = "images/user_male.jpg";
        if($FRIEND_ROW['gender'] == "Female")
        {
            $image = "images/user_female.jpg";
        }

        if(file_exists($FRIEND_ROW['profile_image']))
        {
            $image = $image_class->get_thumb_profile($FRIEND_ROW['profile_image']);
        }
    ?>

    <div style="text-align: center; margin-top: 20px; text-decoration: none;">
        <img id="friends_img" style="border: solid 2px gold; border-radius: 5px;" src="<?php echo $image ?>" alt="Profile Image">
        <a href="profile.php?id=<?php echo $FRIEND_ROW['userid']; ?>" style="text-decoration: none;color: black;">
            <?php echo htmlspecialchars($FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name']) ?>
        </a>
        <br>
        <span style="color: black;"><?php echo htmlspecialchars($FRIEND_ROW['title']) ?></span>
        <br><br>
        
        <a href="profile.php?id=<?php echo $FRIEND_ROW['userid'] ?>">
            <input id="post_button" type="button" value="Following <?php echo htmlspecialchars($stars) ?>" style="margin-right:10px;width:auto;">
        </a>
    </div>

    <div style="text-align: left;">
        <?php 
            $online = "Last seen: <br> Unknown";
            if($FRIEND_ROW['online'] > 0){
                $last_seen = $FRIEND_ROW['online'];
                $current_time = time();
                $threshold = 60 * 2; // 2 minutes

                if(($current_time - $last_seen) < $threshold){
                    $online = "<span style='color:blue;'>online</span>";
                } else {
                    $online = date("Y-m-d H:i:s", $last_seen);
                }
            }
        ?>
        <span style="color: grey; font-size: 11px; font-weight: normal;">Last seen: <?php echo $online ?></span>
    </div>
</div>
