<?php 

$corner_image = "images/user_male.jpg";
if (isset($USER)) { 
    if (file_exists($USER['profile_image'])) {
        $image_class = new Image();
        $corner_image = $image_class->get_thumb_profile($USER['profile_image']);
    } else {
        if ($USER['gender'] == "Female") {
            $corner_image = "images/user_female.jpg";  
        }
    }
}
?>

<div id="blue_bar">
    <form method="get" action="search.php">
        <div style="margin-right: 150px;padding-left: 50px;font-size:30px;">
            <a href="index.php" style="color:white; text-decoration: none; text-shadow: 1px 1px 2px #161616, 0 0 25px white, 0 0 5px #a1ff44;">
                Star
            </a>&nbsp &nbsp<input type="text" id="search_box" name='find' placeholder="Search for People">

            <?php if (isset($USER)): ?>
                <a href="profile.php">
                    <img src="<?php echo $corner_image ?>" style="width:50px;float:right; margin:5px; border-radius: 10%;">
                </a>

                <a href="notifications.php">
                    <span style="display: inline-block; position: relative;">
                        <svg fill="white" style="float: right; margin-top: 10px;" width="25" height="25" viewBox="0 0 24 24">
                            <path d="M12 24c1.326 0 2.402-1.076 2.402-2.402h-4.804c0 1.326 1.076 2.402 2.402 2.402zm8.197-6.097v-6.797c0-3.416-2.248-6.284-5.326-7.292v-.915c0-1.374-1.1-2.475-2.475-2.475s-2.475 1.101-2.475 2.475v.915c-3.078 1.008-5.326 3.876-5.326 7.292v6.797l-2.402 2.402v1.201h19.203v-1.201l-2.402-2.402zm-8.197-19.504c.687 0 1.247.56 1.247 1.247s-.56 1.247-1.247 1.247-1.247-.56-1.247-1.247.56-1.247 1.247-1.247z"/>
                        </svg>
                        <?php 
                            $notif = check_notifications();
                        ?>
                        <?php if ($notif > 0): ?>
                            <div style="background-color: red;color: white;position: absolute;right:-10px;top:0;
                            width:20px;height: 20px;border-radius: 50%;padding: 2px;text-align:center;font-size: 14px;"><?= $notif ?></div>
                        <?php endif; ?>
                    </span></a>
                <a href="messages.php">
                    <span style="display: inline-block; position: relative; margin-left: 10px;">
                        <svg fill="white" style="float: right; margin-top: 10px;" width="25" height="25" viewBox="0 0 24 24">
                            <path d="M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z" />
                        </svg>
                        <?php 
                            $notif = check_messages();
                        ?>
                        <?php if ($notif > 0): ?>
                            <div style="background-color: red;color: white;position: absolute;right:-10px;top:0;
                            width:20px;height: 20px;border-radius: 50%;padding: 2px;text-align:center;font-size: 14px;"><?= $notif ?></div>
                        <?php endif; ?>
                    </span>
                </a>
            <?php else: ?>
                <a href="login.php">
                    <span style="font-size: 11px; float: right; margin:10px; color:white;">Login</span>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>
