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
            echo "<a href='profile.php?id=$COMMENT[userid]' style='text-decoration: none;'>";
            echo htmlspecialchars($ROW_USER['first_name']) . "  " . htmlspecialchars($ROW_USER['last_name']); 
            echo "</a>";

            if($COMMENT['is_profile_image'])
            {
                $pronoun = "his";
                if($ROW_USER['gender'] == "Female")
                {
                  $pronoun = "her";
                }
                echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun profile image</span>";

            }
             
              if($COMMENT['is_cover_image'])
            {
                $pronoun = "his";
                if($ROW_USER['gender'] == "Female")
                {
                  $pronoun = "her";
                }
                echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun cover image</span>";

            }
                
        ?>
        </div>
<!--        <?php echo htmlspecialchars ($COMMENT['post']) ?>-->
                <?php echo check_titles($COMMENT['post']) ?>

        <br><br>

        <?php
    
        if(file_exists($COMMENT['image']))
        {
            
            $post_image = $image_class->get_thumb_post($COMMENT['image']);
                
            echo "<img src='$post_image' style='width:100%;' />";
        }
        ?>

        <br/><br/>
        <?php
            $stars = "";
        
            $stars = ($COMMENT['stars'] > 0) ? "(" .$COMMENT['stars']. ")" : "" ;

        ?>
        <a href="star.php?type=post&id=<?php echo $COMMENT['postid'] ?>" style="text-decoration: none;">Star<?php echo $stars ?></a> .
<!--        <a href="single_post.php?id=<?php echo $COMMENT['postid']?>">Comment</a> .-->
        <span style="color: #999;">Date & Time:
            <?php echo $COMMENT['date'] ?>
        </span>

        <?php 
        
          if($COMMENT['has_image']){
              
            echo " <a href='image_view.php?id=$COMMENT[postid]' > ";
            echo " . View Full Image . ";
            echo " </a> ";
              
          }
        ?>

        <span style="color:#fff;float:right;" style="text-decoration: none;">

            <?php
            
              $post = new Post();

               if($post->i_own_post($COMMENT['postid'],$_SESSION['star_userid'])){

                       echo "<a href='edit.php?id=$COMMENT[postid]' style='text-decoration: none;'> Edit </a> . ";
                  }
            
                if(i_own_content($COMMENT)){

                        echo "<a href='delete.php?id=$COMMENT[postid]' style='text-decoration: none;'> Delete </a>";
                }          

            ?>
        </span>

        <?php
        
				$i_starred = false;

				if(isset($_SESSION['star_userid'])){

					$DB = new Database();

					$sql = "select stars from stars where type='post' && contentid = '$COMMENT[postid]' limit 1";
					$result = $DB->read($sql);
					if(is_array($result)){

						$stars = json_decode($result[0]['stars'],true);

						$user_ids = array_column($stars, "userid");
		 
						if(in_array($_SESSION['star_userid'], $user_ids)){
							$i_starred = true;
						}
					}

				}

			 	if($COMMENT['stars'] > 0){

			 		echo "<br/>";
			 		echo "<a href='stars.php?type=post&id=$COMMENT[postid]'>";

			 		if($COMMENT['stars']  == 1){

			 			if($i_starred){
			 				echo "<div style='text-align:left; text-decoration: none;'>You starred this Star </div>";
			 			}else{
                            //last 3 star oppinion
			 				echo "<div style='text-align:left; text-decoration: none;'> 1 person starred this Star </div>";
			 			}
			 		}else{

			 			if($i_starred){

			 				$text = "others";
			 				if($COMMENT['stars'] - 1 == 1){
			 					$text = "other";
			 				}
			 				echo "<div style='text-align:left; text-decoration: none;'> You and " . ($COMMENT['stars'] - 1) . " $text starred this Star </div>";
			 			}else{
			 				echo "<div style='text-align:left; text-decoration: none;'>" . $COMMENT['stars'] . " other starred this Star </div>";
			 			}
			 		}

			 		echo "</a>";

			 	}
			?>
    </div>
</div>
