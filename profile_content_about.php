<div style="min-height: 800px; width:100%; background-color: white; text-align: center;">
    <div style="padding: 20px; max-width:800px; display: inline-block;">
        <br>
        <br>
        <form method="post" enctype="multipart/form-data">
        
            <?php
            $settings_class = new Settings();
            $settings = $settings_class->get_settings($_SESSION['star_userid']);
            if(is_array($settings)){ 
                echo "<div style='margin-bottom: -24px;text-align: left;'>Full Name:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 542px;'>". htmlspecialchars($settings['first_name'] . " " . $user_data['last_name']) . "</div><br>";
                echo "<div style='margin-bottom: -24px;text-align: left;'>Title:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 668px;'>". htmlspecialchars($settings['title']) . "</div><br>";
                echo "<div style='margin-bottom: -24px;text-align: left;'>School:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 575px;'>". htmlspecialchars($settings['school']) ."</div><br>";
                echo "<div style='margin-bottom: -24px;text-align: left;'>College:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 552px;'>". htmlspecialchars($settings['college']) . "</div><br>";
                echo "<div style='margin-bottom: -24px;text-align: left;'>University:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 550px;'>". htmlspecialchars($settings['university']) . "</div><br>";
                echo "<div style='margin-bottom: -24px;text-align: left;'>Url:</div>";
                echo "<div style='height: 20px; border: none; padding: 5px; background-color: #f9f9f9; padding-right: 700px;'>". htmlspecialchars($settings['url']) . "</div><br>";
                echo "<div style='margin-bottom: 10px;'>About Me:</div>";
                echo "<div style='border: none; padding: 5px; background-color: #f9f9f9; text-align: justify;'>". htmlspecialchars($settings['about']) . "</div><br>";
            }
            ?>
            
        </form>
    </div>
</div>
