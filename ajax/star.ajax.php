<?php

  $login = new Login();
  $_SESSION['star_userid'] = isset($_SESSION['star_userid']) ? $_SESSION['star_userid'] : 0;
  $user_data = $login->check_login($_SESSION['star_userid'],false);

  //check if not logged in
    if($_SESSION['star_userid'] == 0){

    $obj = (object)[];
    $obj->action = "star_post";

    echo json_encode($obj);
    die;
    }

    $query_string = explode("?", $data->link);
    $query_string = end($query_string);

    $str = explode("&", $query_string);

      foreach ($str as $value) {
          # code ...
          $value = explode("=", $value);
          $_GET[$value[0]] = $value[1];
      }

$_GET['id'] = addslashes($_GET['id']);
$_GET['type'] = addslashes($_GET['type']);

   if(isset($_GET['type']) && isset ($_GET['id'])){
       
    $post = new Post();
 
    if(is_numeric($_GET['id'])){
        
        $allowed[] = 'post';
        $allowed[] = 'user';
        $allowed[] = 'comment';
        
    if(in_array($_GET['type'], $allowed)){
            
        $user_class = new User();
        $post->star_post($_GET['id'],$_GET['type'],$_SESSION['star_userid']);                     
                                        
        if($_GET['type'] == "user"){
           $user_class->follow_user($_GET['id'],$_GET['type'],$_SESSION['star_userid']);

        }
        
       }
        
    }
       
    //read stars
    $stars = $post->get_stars($_GET['id'],$_GET['type']);
       
    //create info 
       $stars = array();
       $info = "";
       
        $i_starred = false;

				if(isset($_SESSION['star_userid'])){
                    
            $DB = new Database();

            $sql = "setect stars from stars where type='post' && contentid = '$_GET[id]' limit 1"; 
            $result = $DB->read($sql); 
            if(is_array($result)){
            
            $stars = json_decode($result[0]['stars'],true);
            
            $user_ids = array_column($stars, "userid");
            
            if(in_array($_SESSION['$star_userid'], $user_ids)){
                $i_starred = true; 
              }
            }
         }
        
        $star_count = count($stars);
       
        if($star_count > 0){
            
            $info .= "<br/>";
              
            if($star_count == 1){
                
            if($i_starred){
              $info.= "<div style='text-align:left;'>You starred this post </div>";
            }else{     
              $info.= "<div style='text-align:left;'>1 person starred this post </div>";
           }
        }else{
            if($i_starred){
                
                $text = "others";
                if($star_count - 1 == 1){
                $text = "other";
            }
              $info.= "<div style='text-align:left;'> You and " . ($star_count -1) . " $text  starred this post</div>";
         }else{
              $info.= "<div style='text-align:left;'>" . $star_count . " other starred this post</div>";
            }
           
        }  
      }

       
    $obj = (object)[];  
    $obj->stars = count($stars);  
    $obj->action = "star_post";
    $obj->info = $info;
    $obj->id = "info_$_GET[id]";
       
       echo json_encode($obj);
       
   }
  
