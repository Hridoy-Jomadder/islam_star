<?php 

class Post
{
    private $error = "";
    
	public function create_post($userid, $data, $files)
	{

		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image']))
		{
            
            $myimage = "";
            $has_image = 0;
            $is_cover_image = 0;
            $is_profile_image = 0;
            
            if(isset($data['is_profile_image']) || isset($data['is_cover_image']))
               {
                
                   $myimage = $files;
                   $has_image = 1;
                
                   if(isset($data['is_cover_image']))
                   {
                      $is_cover_image = 1;
                   }
                
                   if(isset($data['is_profile_image']))
                   {
                       $is_profile_image = 1;
                   }
               }else
               {
                
                    if(!empty($files['file']['name']))
                    {

                    $folder= "uploads/" . $userid . "/";

                          //create folder
                          if(!file_exists($folder))
                             {

                                 mkdir($folder,0777,true);
                                 file_put_contents($folder . "index.php", "");
                             }

                          $image_class = new Image();

                        $myimage = $folder . $image_class->generate_filename(15) . ".jpeg";
                        move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                        $image_class->resize_image($myimage,$myimage,1500,1500);

                    $has_image = 1;
                    }
        }
               
        $post = ""; 
        if(isset($data['post'])){
          $post = addslashes($data['post']);
        }
            
    if($this->error == ""){    //Date: 9/1/2023
            
            $postid = $this->create_postid();
            $parent = 0;
            $DB = new Database();

            if(isset($data['parent']) && is_numeric($data['parent'])){

                    $parent = $data['parent'];
                    $mypost = $this->get_one_post($data['parent']);

                if(is_array($mypost) && $mypost['userid'] != $userid){

                    //follow this item
                    content_i_follow($userid,$mypost);

                    //add notification
                    add_notification($_SESSION['star_userid'],"comment",$mypost);
                }
                    $sql = "update posts set comments = comments + 1 where postid = '$parent' limit 1";
                    $DB->save($sql);
                }

            $query = "insert into posts (userid,postid,post,image,has_image,is_profile_image,is_cover_image,parent) values  ('$userid','$postid','$post','$myimage','$has_image','$is_profile_image','$is_cover_image','$parent')";
            $DB->save($query);

            }else
            {
                $this->error .= "Please type something to post!<br>";
            }

            return $this->error;
        }
    }
    public function edit_post($data, $files)
	{

		if(!empty($data['post']) || !empty($files['file']['name']))
		{
            
            $myimage = "";
            $has_image = 0;
               
                if(!empty($files['file']['name']))
                {

                    $folder= "uploads/" . '$userid' . "/";

                          //create folder
                          if(!file_exists($folder))
                             {
    
                                 mkdir($folder,0777,true);
                                 file_put_contents($folder . "index.php", "");
                             }

                        $image_class = new Image();

                        $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                        move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                        $image_class->resize_image($myimage,$myimage,1500,1500);

                    $has_image = 1;
                    
                 }
        
        $post = ""; 
        if(isset($data['post'])){
            
           $post = addslashes($data['post']);

        }
               
        $postid = addslashes($data['postid']);
            
        if($has_image){
              $query = "update posts set post = '$post', image = '$myimage' where postid = '$postid' limit 1";
        }else{
             $query = "update posts set post = '$post' where postid = '$postid' limit 1";
        }
            
         //notify those that were tagged
         title($postid, $post);
            
            $DB = new Database();
            $DB->save($query);

		}else
		{
			$this->error .= "Please type something to post!<br>";
		}
        
        return $this->error;
    }
    
    public function get_posts($id)
    {

		$page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  		$page_number = ($page_number < 1) ? 1 : $page_number;

		$limit = 5;
 		$offset = ($page_number - 1) * $limit;

		$query = "select * from posts where parent = 0 and userid = '$id' order by id desc limit $limit offset $offset";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}
    
    public function get_comments($id)
    {
        
        $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page_number = ($page_number < 1) ?  1 : $page_number;
        // limit add number
        $limit = 2;
        $offset = ($page_number - 1) * $limit;
		$query = "select * from posts where parent = '$id' order by id asc limit $limit offset $offset";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}else
		{
			return false;
		}
	}
    
	public function get_one_post($postid)
	{

		if(!is_numeric($postid)){

			return false;
		}

		$query = "select * from posts where postid = '$postid' limit 1";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}else
		{
			return false;
		}
	}

    public function delete_post($postid)
    {
        
        if(!is_numeric($postid)){
            
            return false;
        }
        
        $Post = new Post();
        $one_post = $Post->get_one_post($postid);
        
        $DB = new Database();
        $sql = "select parent from posts where postid = '$postid' limit 1";
        $result = $DB->read($sql);
        
        if(is_array($result)){
            
            if($result[0]['parent'] > 0){
        
            $parent =  $result[0]['parent'];
            
            $sql = "update posts set comments = comments - 1 where postid = '$parent' limit 1";
            $DB->save($sql);
                
            }
        }
        
         $query = "delete from posts where postid = '$postid'  limit 1";
         $DB->save($query);
        
        //delete any images and thumbnails
        if($one_post['image'] != "" && file_exists($one_post['image']))
               {
                  unlink($one_post['image']);
               }
            
            if($one_post['image'] != "" && file_exists($one_post['image']. "_post_thumb"))
               {
                  unlink($one_post['image']. "_post_thumb");
               }
                
            if($one_post['image'] != "" && file_exists($one_post['image']. "_cover_thumb"))
               {
                  unlink($one_post['image']. "_cover_thumb");
               }
        //delete all comments
        $query = "delete from posts where parent = '$postid' ";
        $DB->save($query);
    }
    
    public function i_own_post($postid,$star_userid)
	{

		if(!is_numeric($postid)){
			
			return false;
		}

		$query = "select * from posts where postid = '$postid' limit 1";

		$DB = new Database();
		$result = $DB->read($query);
  		
  		if(is_array($result)){

  			if($result[0]['userid'] == $star_userid){

  				return true;
  			}
  		}

  		return false;
	}
    
    public function get_stars($id,$type){
                
    $type = addslashes($type);
   
    if(is_numeric($id)){
        
       // get star details
     $sql = "setect stars from stars where type='$type' && contentid = '$id' limit 1"; 
     $DB = new Database();

     $result = $DB->read($sql); 
     if(is_array($result)){
            
            $stars = json_decode($result[0]['stars'],true);
            return $stars;
        }
      }
        return false;
    }
    
    public function star_post($id,$type,$star_userid){
              
        $DB = new Database();
   
        // save stars details //post? $type
        $sql = "setect stars from stars where type='$type' && contentid = '$id' limit 1"; 
        $result = $DB->read($sql); 
        if(is_array($result)){
            
            $stars = json_decode($result[0]['stars'],true);
            
            $user_ids = array_column($stars, "userid");
            
        if(!in_array($star_userid, $user_ids)){
                
            $arr["userid"] = $star_userid;
            $arr["date"] = date("Y-m-d H:i:s");
                
            $stars[] = $arr;    
            
            $stars_string = json_encode($stars);
            $sql = "update stars set stars = '$stars_string' where type='$type' && contentid = '$id' limit 1"; 
            $DB->save($sql);
                
            //increment the right table
            $sql = "update  {$type}s set stars = stars + 1 where {$type}id = '$id' limit 1"; 
            $DB->save($sql); 
            
            if($type != "user"){
                $post = new  Post();
                $single_post = $post->get_one_post($id);

                 //add notification
                add_notification($_SESSION['star_userid'],"star",$single_post);
                }
                
            }else{
               
                $key = array_search($star_userid, $user_ids);
                unset($stars[$key]);
                
                $stars_string = json_encode($stars);
                $sql = "update stars set stars = '$stars_string' where type='$type' && contentid = '$id' limit 1"; 
                $DB->save($sql);
                
                 //increment the right table
                $sql = "update {$type}s set stars = stars - 1 where  {$type}id = '$id' limit 1"; 
                $DB->save($sql); 
            }
            
        }else{
            
            $arr["userid"] = $star_userid;
            $arr["date"] = date("Y-m-d H:i:s");
            
            $arr2[] = $arr;
            
            $stars = json_encode($arr2);
            $sql = "insert into stars (type,contentid,stars) values ('$type','$id','$stars')"; 
            $DB->save($sql); 
            
             //increment the right table
            $sql = "update  {$type}s set stars = stars + 1 where {$type}id = '$id' limit 1"; 
            $DB->save($sql);
            
            if($type != "user"){
                $post = new  Post();
                $single_post = $post->get_one_post($id);

                 //add notification
                add_notification($_SESSION['star_userid'],"star",$single_post);
        }

     }
}
    
    
	private function create_postid()
	{

		$length = rand(4,19);
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			# code...
			$new_rand = rand(0,9);

			$number = $number . $new_rand;
		}

		return $number;
	}
}
//,following ,'$following' line 377