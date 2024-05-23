<?php 

 function pagination_link(){
     
     $page_number = isset($_GET['page']) ? (int)$_GET['page'] : 1;
     $page_number = ($page_number < 1) ?  1 : $page_number;
     
     $arr['next_page'] = "";
     $arr['previs_page'] = ""; 
     
     //get current url
    $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
    $url .= "?";

    $next_page_link = $url;
    $previs_page_link = $url;
    $page_found = false;

    $num = 0;
    foreach ($_GET as $key => $value) {
    # code...
    $num++;

    if($num == 1){
      if($key == "page"){

          $next_page_link .= $key ."=" . ($page_number + 1);
          $previs_page_link .= $key ."=" . ($page_number - 1);
          $page_found = true;
        }else{

            $next_page_link .= $key ."=" . $value;
            $previs_page_link .= $key ."=" . $value;
        }
      }else{
            if($key == "page"){

            $next_page_link .= "&" . $key ."=" . ($page_number + 1);
            $previs_page_link .= "&" . $key ."=" . ($page_number - 1);
            $page_found = true;

        }else{
                $next_page_link .= "&" . $key ."=" . $value;
                $previs_page_link .= "&" . $key ."=" . $value;
         }
      }
    }

     $arr['next_page'] = $next_page_link;
     $arr['previs_page'] = $previs_page_link;
     
     if(!$page_found){
         
         $arr['next_page'] = $next_page_link . "&page=2";
         $arr['previs_page'] = $previs_page_link . "&page=1";
     }
     
     return $arr;
	}

function i_own_content($row){
    
    $myid = $_SESSION['star_userid'];
    
    //Profiles
    if(isset($row['gender'])  && $myid == $row['userid']){
    
       return true;
    }
    
    //Messages
    if(isset($row['sender']) && $myid == $row['sender']){
    
       return true;
    }
    
    //comments and posts
    if(isset($row['postid'])){
    
        if($myid == $row['userid']){
            return true;
         }else{
                    
            $Post = new Post();
            $one_post = $Post->get_one_post($row['parent']);

            if($myid == $one_post['userid']){
            return true;
                }
            }
        }
        
        return false;
    }
	
function title($postid,$new_post_text = "")
{

	$DB = new Database();
	$sql = "select * from posts where postid = '$postid' limit 1";
	$mypost = $DB->read($sql);

	if(is_array($mypost)){
		$mypost = $mypost[0];

		if($new_post_text != ""){
			$old_post = $mypost;
			$mypost['post'] = $new_post_text;
		}

		$titles = get_titles($mypost['post']);
		foreach ($titles as $title) {
			# code...
			$sql = "select * from users where title_name = '$title' limit 1";
			$titled_user = $DB->read($sql);
			if(is_array($titled_user)){

				$titled_user = $titled_user[0];

				if($new_post_text != ""){
					$old_titles = get_titles($old_post['post']);
					if(!in_array($titled_user['title_name'], $old_titles)){
						add_notification($_SESSION['star_userid'],"title",$mypost,$titled_user['userid']);
					}
				}else{
					
					//title
					add_notification($_SESSION['star_userid'],"title",$mypost,$titled_user['userid']);
 				}

			}
		}
	}
}

function add_notification($userid,$activity,$row,$titled_user = '')
{
    $row = (object)$row;
    $userid = esc($userid);
    $activity = esc($activity);
    $content_owner = $row->$userid;
    
    if($titled_user != ""){
          $content_owner = $titled_user;
        }

    $date = date("Y-m-d H:i:s");
    $contentid = 0;
    $content_type = "";

    if(isset($row->postid)){
       $contentid = $row->postid;
       $content_type = "post";
        
        if($row->parent > 0){
              $content_type = "comment";
        }
    }    
    
    if(isset($row->gender)){
      $content_type = $row->type; //cheack korar por delete koro
      $contentid = $row->userid;

    }
    
    $query = "insert into notifications (userid,activity,content_owner,date,contentid,content_type) 
    values ('$userid','$activity','$content_owner','$date','$contentid','$content_type')";
    $DB = new Database();
    $DB->save($query);
    
}

function content_i_follow($userid,$row)
{
    $row = (object)$row;
    $userid = esc($userid);
    $date = date("Y-m-d H:i:s");
    $contentid = 0;
    $content_type = "";

    if(isset($row->postid)){
       $contentid = $row->postid;
       $content_type = "post";
        
        if($row->parent > 0){
              $content_type = "comment";
            }
    }
    
    if(isset($row->gender)){
      $content_type = "profile";
    }
    
    $query = "insert into content_i_follow (userid,date,contentid,content_type) values ('$userid','$date','$contentid','$content_type')";
    $DB = new Database();
    $DB->save($query);
}

function esc($Value)
{
    
    return addslashes($Value);
}

function notification_seen($id)
{

	$notification_id = addslashes($id);
	$userid = $_SESSION['star_userid'];
	$DB = new Database();

	$query = "select * from notification_seen where userid = '$userid' && notification_id = '$notification_id' limit 1";
	$check = $DB->read($query);

	if(!is_array($check)){

		$query = "insert into notification_seen (userid,notification_id) values ('$userid','$notification_id')";
		
		$DB->save($query);
	}
}

function check_notifications()
{
	$number = 0;

	$userid = $_SESSION['star_userid'];
	$DB = new Database();

	$follow = array();

	//check content i follow
	$sql = "select * from content_i_follow where disabled = 0 && userid = '$userid' limit 100";
	$i_follow = $DB->read($sql);
	if(is_array($i_follow)){
		$follow = array_column($i_follow, "contentid");
	}

	if(count($follow) > 0){

		$str = "'" . implode("','", $follow) . "'";
		$query = "select * from notifications where (userid != '$userid' && content_owner = '$userid') || (contentid in ($str)) order by id desc limit 30";
	}else{

		$query = "select * from notifications where userid != '$userid' && content_owner = '$userid' order by id desc limit 30";
	}
 							
 	$data = $DB->read($query);

 	if(is_array($data)){

 		foreach ($data as $row) {
 			# code...
	 		$query = "select * from notification_seen where userid = '$userid' && notification_id = '$row[id]' limit 1";
			$check = $DB->read($query);

			if(!is_array($check)){

				$number++;
			}
		}
	}

	return $number;

}

function check_titles($text)
{
	$str = "";
	$words = explode(" ", $text);
	if(is_array($words) && count($words)>0)
	{
		$DB = new Database();
		foreach ($words as $word) {

			if(preg_match("/@[a-zA-Z_0-9\Q,.\E]+/", $word)){
				
				$word = trim($word,'@');
				$word = trim($word,',');
				$title_name = esc(trim($word,'.'));

				$query = "select * from users where title_name = '$title_name' limit 1";
				$user_row = $DB->read($query);

				if(is_array($user_row)){
					$user_row = $user_row[0];
					$str .= "<a href='profile.php?id=$user_row[userid]'>@" . $word . "</a> ";
				}else{

					$str .= htmlspecialchars($word) . " ";
				}
 			
			}else{
				$str .= htmlspecialchars($word) . " ";
			}
		}

	}

	if($str != ""){
		return $str;
	}

	return htmlspecialchars($text);
}

function get_titles($text)
{
	$titles = array();
	$words = explode(" ", $text);
	if(is_array($words) && count($words)>0)
	{
		$DB = new Database();
		foreach ($words as $word) {

			if(preg_match("/@[a-zA-Z_0-9\Q,.\E]+/", $word)){
				
				$word = trim($word,'@');
				$word = trim($word,',');
				$title_name = esc(trim($word,'.'));

				$query = "select * from users where title_name = '$title_name' limit 1";
				$user_row = $DB->read($query);

				if(is_array($user_row)){
					
					$titles[] = $word;
				}
 			
			}
		}

	}
 
	return $titles;
}

if(isset($_SESSION['star_userid'])){
    set_online($_SESSION['star_userid']);
}
function set_online($id){
    
    if(!is_numeric($id)){
    return;
    }
    
    $online = time();
    $query = "update users set online = '$online' where userid = '$id' limit 1";
    $DB = new Database();
    $DB->save($query);
}

function show($data){

	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
    
function check_messages(){

	$DB = new Database();
	$me = esc($_SESSION['star_userid']);
 
	$query = "select * from messages where (receiver = '$me' && deleted_receiver = 0 && seen = 0) limit 100";
	$data = $DB->read($query);

	if(is_array($data)){
		return count($data);
	}
	return 0;
}

function check_seen_thread($msgid){

	$DB = new Database();
	$me = esc($_SESSION['star_userid']);
 
	$query = "select * from messages where (receiver = '$me' && deleted_receiver = 0 && seen = 0 && msgid = '$msgid') limit 100";
	$data = $DB->read($query);

	if(is_array($data)){
		return count($data);
	}
	return 0;
}





// Define a function to generate the dropdown menu
// function generateDropdownMenu($postId) {
//     echo '<div class="dropdown" style="float:right;">';
//     //echo '    <button class="dropbtn"><img src="images/dots0.png"></button>';
//     echo '    <div class="dropdown-content" style="right:0;">';
//     echo '        <a href="#" onclick="copyLink(' . $postId . ')">Copy Link</a>';
//     echo '        <a href="#" onclick="reportPost(' . $postId . ')">Report Post</a>';
//     echo '        <a href="#" onclick="saveLink(' . $postId . ')">Save Link</a>';
//     echo '    </div>';
//     echo '</div>';
// }

// Example usage:
$postId = 82473; // Replace 123 with the actual ID of the post
// generateDropdownMenu($postId);
?>



<script>
    // JavaScript function to copy the link
    function copyLink(postId) {
        // Logic to copy the link goes here
        var postLink = "http://localhost/StarShort/single_post.php?id=" + postId;
        navigator.clipboard.writeText(postLink).then(function() {
            alert("Link copied successfully: " + postLink);
        }, function() {
            alert("Failed to copy link.");
        });
    }

    // JavaScript function to report the post
    function reportPost(postId) {
        // Logic to report the post goes here
        // You can use AJAX to send a report request to the server
        alert("Post with ID " + postId + " reported successfully.");
    }

    // JavaScript function to save the link
    function saveLink(postId) {
        // Logic to save the link goes here
        // You can use localStorage or AJAX to save the link
        alert("Link saved successfully: http://localhost/StarShort/single_post.php?id=" + postId);
    }
</script>

