<div id="message_right" style="background-color: #eee;">
    <div style="width: 100%; text-align:right;">
        <div style="font-weight:bold;color:#405d9b;width:100%;">
            <?php 
            echo "<a href='profile.php/$MESSAGE[msgid]'>";
            echo htmlspecialchars($ROW_USER['first_name']) . "  " . htmlspecialchars($ROW_USER['last_name']); 
            echo "</a>";
                
        ?>
        </div>
        
        <?php echo check_titles($MESSAGE['message']) ?>

        <?php
    
        if(file_exists($MESSAGE['file']))
        {
            
            $post_image = $image_class->get_thumb_post($MESSAGE['file']);
                
            echo "<img src='$post_image' style='width:100%;' />";
        }
        ?>

        <br /><br />

        <!--
        <span style="color: #999;">
            <?php echo $MESSAGE['date'] ?>
        </span>
-->

        <?php 
        
          if(file_exists($MESSAGE['file'])){
            
            echo " <a href='image_view.php?id=$MESSAGE[id]' > ";
            echo " . View Full Image . ";
            echo " </a> ";
          }
        ?>

        <span style="color:#fff;float:left;">
            <?php
            
              $post = new Post();

                echo "<a  href='delete.php?id=$MESSAGE[id]' >"; 
                echo '<svg fill="orange" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg>'; 
                echo " </a>";
            ?>
        </span>

      </div>
<!--a label-->
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
</div>
