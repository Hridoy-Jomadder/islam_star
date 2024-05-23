<div style="min-height: 400px; width:100%; background-color: white; text-align: center;">
    <div style="padding: 20px;">
        <?php
        
             $image_class = new Image();
             $post_class = new Post();
             $user_class = new User();

             $followers = $post_class->get_stars($user_data['userid'],"user");

             var_dump($followers);
            if(is_array($followers)){

            foreach ($followers as $follower) {
                #code...
                $FRIEND_ROW = $user_class->get_user($follower['userid']);
                include("user.php");
            }

          }else{

            echo "No followers  were found!";
         }
       ?>

    </div>
</div>
