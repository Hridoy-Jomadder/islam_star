   <!--  below  cover area-->
   <div style="display: flex;">

       <!--    Post area-->
       <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-left: 0px;">
           <div style="border: solid thin #aaa; padding: 10px; background-color: white; font-family: times new roman;">

               <form method="post" enctype="multipart/form-data" accept-charset="UTF-8" style="font-family: 'Nikosh',sans-serif;">

                   <textarea name="post" placeholder=" What knowledge do you want to share with Star? Do you start?"></textarea>
                   <input type="file" name="file" style="font-family: times new roman;">
                   <input id="post_button" type="submit" value="Publish">
                   <br>
            <!--  -->
</form>


               <br>
           </div>
           <!--post_bar-->
           <div id="post_bar">

               <?php 
                     //var_dump($posts);
                   if($posts){  
                    
                        foreach($posts as $ROW){
                        #code....
                        $user = new User();
                        $ROW_USER = $user->get_user($ROW['userid']);

                        include("post.php");    
                        }
                    }
               
                    //get current url
                    $pg = pagination_link();
               
                  ?>
               <a href="<?= $pg['next_page'] ?>">
                   <input id="post_button" type="button" value="Next Page" style="float:right; width:25%;">
               </a>
               <a href="<?= $pg['previs_page'] ?>">
                   <input id="post_button" type="button" value="Previous page" style="float:left; width:25%;">
               </a>
           </div>
       </div>

       <!--  Friends area-->
       <div style="min-height: 400px; flex: 1;">

           <div id="friends_bar">
               <br>
               Following<br>

               <?php  
                        //var_dump($friends);
                          if($friends){

                                foreach($friends as $friend){
                                    # code....
                                    $user = new User();
                                    $FRIEND_ROW = $user->get_user($friend['userid']);
                                    include("user.php");
                                }                                
                          }
                         ?>
           </div>
           <br>
           <a href="profile.php?section=following&id=<?php echo  $user_data['userid'] ?>" style="float:right;">
               <!--<div id="menu_buttons"><input id="See_More" type="submit" value="See More"></div>-->
           </a>

       </div>
   </div>
