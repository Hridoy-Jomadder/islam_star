    <div id="post">
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

            <img src="<?php echo $image ?>" style='width: 50px; margin-right: 20px;border-radius: 50%;'>
        </div>
        <div style="width: 100%;">
            <div style="font-weight: bold;color: #405d9b;width: 100%;"><br>
                <?php 
                            echo "<a href='profile.php?id=$ROW[userid]' style='text-decoration: none;'>";
                            echo htmlspecialchars($ROW_USER['first_name']) . "  " . htmlspecialchars($ROW_USER['last_name']); 
                            echo "</a>";

                        if($ROW['is_profile_image'])
                        {
                            $pronoun = "his";
                            if($ROW_USER['gender'] == "Female")
                            {
                              $pronoun = "her";

                            }
                            echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun profile image</span>";

                        }

                          if($ROW['is_cover_image'])
                        {
                            $pronoun = "his";
                            if($ROW_USER['gender'] == "Female")
                            {
                              $pronoun = "her";

                            }
                            echo "<span style='font-weight:normal;color:#aaa;'> updated $pronoun cover image</span>";

                        }

                      ?>
                <br>
            </div>

        <!-- HTML code for the dropdown menu -->
        <div class="dropdown" style="float:right;">
            <button class="dropbtn"><img src="images/dots0.png"></button>
            <div class="dropdown-content" style="right:0;">
                <!-- Triggering JavaScript functions for each action -->
                <a href="#" onclick="copyLink(<?php echo $postId; ?>)">Copy Link</a>
                <a href="#" onclick="reportPost(<?php echo $postId; ?>)">Report Post</a>
                <a href="#" onclick="saveLink(<?php echo $postId; ?>)">Save Link</a>
            </div>
        </div>

            
            <!--
            <span style="color: #000;float:right;">
            
            <a href="#">
            
            <img src="images/dots0.png"></a>
            
            </span>
-->

            <!--            <div style="text-align: right; padding-top: 0px; font-size: 40px;"><bold >..</bold></div>-->

            <span style=""><?php echo $user_data['title'] ?></span>
            <br>
            <br>

            <!--  add div-->
            <div style="font-family: times new roman;  color: black; ">
                <?php echo check_titles($ROW['post']) ?>
            </div>

            <br><br>

            <?php
    
                if(file_exists($ROW['image']))
                 {
                     $post_image = $image_class->get_thumb_post($ROW['image']);
                    
//                     echo '<a href="single_post.php?id' . $ROW['postid'] . '">';
                       echo "<img src='$post_image' style='width:100%;' />";
//                     echo '</a>';
                }
        
            ?>
            <br /><br />

            <?php
            
                $stars = "";

                $stars = ($ROW['stars'] > 0)  ? "(" .$ROW['stars']. ")" : "" ;
            ?><img src="images/star_icon.png" style="display: block;">
            <a onclick="star_post(event)" href="star.php?type=post&id=<?php echo $ROW['postid'] ?>" style="text-decoration: none;">Star<?php echo $stars ?></a> .
           
            <?php 
    
                $comments = ""; 

                   if($ROW['comments'] > 0){

                       $comments = "(" . $ROW['comments'] . ")";
                   }

            ?>

            <a href="single_post.php?id=<?php echo $ROW['postid'] ?>" style="text-decoration: none;">Opinion<?php echo $comments ?></a> .

            <?php 
        
                if($ROW['has_image']){

                    echo "<a href='image_view.php?id=$ROW[postid]' style='text-decoration: none;'>";
                    echo " View Full Image . ";
                    echo "</a> ";
                 }
            ?>

            <span style="color: #000;float:right;">

                <?php
            
              $post = new Post();

             if($post->i_own_post($ROW['postid'],$_SESSION['star_userid'])){
              
                echo "
                   <a href='edit.php?id=$ROW[postid]' style='text-decoration: none;'>
                      Edit 
                   </a> 
                   .
                   <a href='delete.php?id=$ROW[postid]' style='text-decoration: none;'> 
                       Delete 
                   </a>";

                   }
            ?>
            </span>
            Date & Time:
            <!--date-->
            <span style="color: #000;">
                <?php  echo $ROW['date'] ?>
            </span>
            <hr>
            <?php 
        
                $i_starred = false;

                if(isset($_SESSION['star_userid'])){

                    $DB = new Database();

                    $sql = "setect stars from stars where type='post' && contentid = '$ROW[postid]' limit 1"; 
                    $result = $DB->read($sql);

                    if(is_array($result)){

                        $stars = json_decode($result[0]['stars'],true);

                        $user_ids = array_column($stars, "userid");

                         if(in_array($_SESSION['$star_userid'], $user_ids)){
                            $i_starred = true; 
                          }
                        }
                     }

                     echo "<a id='info_$ROW[postid]' href='stars.php?type=post&id=$ROW[postid]' style='text-align:left; text-decoration: none;'>";

                if($ROW['stars'] > 0){

                    echo "<br/>";

                    if($ROW['stars'] == 1){

                            if($i_starred){
                              echo "<div style='text-align:left; text-decoration: none;'>You starred this post </div>";
                            }else{     
                              echo "<div style='text-align:left; text-decoration: none;'>1 person starred this post </div>";
                           }
                    }else{

                        if($i_starred){

                        $text = "others";
                            if($ROW['stars'] - 1 == 1){
                                $text = "other";
                            }
                              echo "<div style='text-align:left; text-decoration: none;'> You and " . ($ROW['stars'] -1) . " $text  starred this post</div>";
                         }else{
                              echo "<div style='text-align:left; text-decoration: none;'>" . $ROW['stars'] . " other starred this post</div>";
                    }
                }  
              }
                echo"</a>";
            ?>
        </div>
    </div>
    <hr>

    <script type="text/javascript">
        
    function ajax_send(data, element) {

            var ajax = new XMLHttpRequest();

            ajax.addEventListener('readystatechange', function() {

                if (ajax.readyState == 4 && ajax.status == 200) {

                    response(ajax.responseText, element);
                }

            });

            data = JSON.stringify(data);

            ajax.open("post", "ajax.php", true);
            ajax.send(data);

        }

        function response(result, element) {
                   // console.log(result);
            if (result != "") {

                var obj = JSON.parse(result);
                if (typeof obj.action != 'undefined') {

                    if (obj.action == 'star_post') {

                        var stars = "";

                        if (typeof obj.stars != 'undefined') {
                            stars = (parseInt(obj.stars) > 0) ? "Star(" + obj.stars + ")" : "Star";
                            element.innerHTML = stars;
                        }

                        if (typeof obj.info != 'undefined') {
                            var info_element = document.getElementById(obj.id);
                            info_element.innerHTML = obj.info;
                        }
                    }
                }
            }
        }
</script>

     

<!--Image not save-->
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var images = document.getElementsByTagName('img');

            for (var i = 0; i < images.length; i++) {
                images[i].addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                });
            }
        });

    </script>

