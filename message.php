<div id="post" style="background-color: #eee;">
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

        <img src="<?php echo $image ?>" style='width:50px;margin-right:20px;border-radius:50%;'>
    </div>
    <div style="width: 100%;">
        <div style="font-weight:bold;color:#405d9b;width:100%;">
            <?php 
            echo "<a href='profile.php?id=$MESSAGE[msgid]'>";
            echo htmlspecialchars($ROW_USER['first_name']) . "  " . htmlspecialchars($ROW_USER['last_name']); 
            echo "</a>";                
        ?>

        </div>
        <?php echo htmlspecialchars ($MESSAGE['message']) ?>
        <!--        <?php echo check_titles($MESSAGE['message']) ?>-->

        <br><br>
        <?php
    
        if(file_exists($MESSAGE['file'])){
            
            $post_image = $image_class->get_thumb_post($MESSAGE['image']);
                
            echo "<img src='$post_image' style='width:100%;' />";
        }
        ?>

        <br /><br />

        <span style="color: #999;">
            <?php echo $MESSAGE['date'] ?>
        </span>

        <?php 
        
          if(file_exists($MESSAGE['file'])){
            
            echo " <a href='image_view.php?id=$MESSAGE[postid]' > ";
            echo " . View Full Image . ";
            echo " </a> ";
          }
        ?>

        <span style="color:#fff;float:right;">

            <?php
            
              $post = new Post();

                if(i_own_content($MESSAGE)){

                echo "<a href='delete.php?id=$MESSAGE[postid]' > 
                   Delete 
                   </a>";

                }          

            ?>
        </span>
    </div>
</div>
