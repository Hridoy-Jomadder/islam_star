<?php 

Class Messages
{
 private $error = "";
    
	public function send($data, $files, $receiver)
	{

		if(!empty($data['message']) || !empty($files['file']['name']))
		{
            
            $myimage = "";
            $has_image = 0;
         
         if(!empty($files['file']['name'])){
             
                    $userid = $_SESSION['star_userid'];
                    $folder= "uploads/" . $userid . "/";

                          //create folder
                          if(!file_exists($folder))
                             {

                                 mkdir($folder,0777,true);
                                 file_put_contents($folder . "index.php", "");
                             }
             $allowed[] = "image/jpeg";
         //    $allowed[] = "application/pdf";
             
             if(in_array($files['file']['type'], $allowed)){
                        
                $image_class = new Image();

                $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                $image_class->resize_image($myimage,$myimage,1500,1500);

                $has_image = 1;
            }else{
             
             $this->error .= "The select image is not a valid type.only jpeges allowed ";
        }
               
        $message = ""; 
        if(isset($data['message'])){
            
          $message = esc($data['message']);
        }
          
    if(trim($message) == "" && $has_image == 0){
        
        $this->error .= "Please type something to send!<br>";
    }         
                 
    if($this->error == ""){ 
        
        $DB = new Database();
        $msgid = $this->create_msgid(60);
        $sender = esc($_SESSION['star_userid']);
        $receiver = esc($receiver);
        
        //check if thead exists
        $query = "select * from messages where (sender = '$sender' && receiver = '$receiver') || (receiver = '$sender' && sender = '$receiver') limit 1";
        $data = $DB->read($query);
        
        if(is_array($data)){
            $msgid = $data[0]['msgid'];
        }
        
        $file = esc($myimage);
              
        $query = "insert into messages (sender,msgid,receiver,message,file) values  ('$sender','$msgid','$receiver','$myimage','$message','$file')";
        $DB->save($query);
        }
		}else
		{
			$this->error .= "Please type something to send!<br>";
		}
        
        return $this->error;
    }
  }
    public function read($userid){
            
		$DB = new Database();
 		$me = esc($_SESSION['star_userid']);
 		$userid = esc($userid);

 		$query = "select * from messages where ((sender = '$me' && receiver = '$userid') && deleted_sender = 0) || ((receiver = '$me' && sender = '$userid') && deleted_receiver = 0) order by id desc limit 20";
 		$data = $DB->read($query);

 		if(is_array($data)){

 			//set seen to 1
			$msgid = $data[0]['msgid'];
			$query = "update messages set seen = 1 where receiver = '$me' && msgid = '$msgid' ";
			$DB->save($query);
 
 			sort($data);
 		}
 		return $data;
	}
    
    public function read_threads(){
        
        $DB = new Database();
        $me = esc($_SESSION['star_userid']); 
        
//        $query = "select * from message where (sender = '$me' || receiver = '$me') group by msgid order by id desc limit 20";
        $query = "select t1.* from messages t1 join (select id,msgid,max(date) mydate from messages where ((sender = '$me' && deleted_sender = 0) || (receiver = '$me' && deleted_sender = 0)) group by msgid) t2 on t1.msgid = t2.msgid and t2.mydate = t1.date group by msgid";
        $data = $DB->read($query);
        
        if(is_array($data)){
          sort($data);
        }
       return $data;
    }
    
    public function read_one_thread($msgid){
        
        $msgid = esc($msgid);
        $DB = new Database();
        $me = esc($_SESSION['star_userid']); 
        
        $query = "select t1.* from messages t1 join (select id,msgid,max(date) mydate from messages where(sender = '$me' || receiver = '$me') && msgid = '$msgid' group by msgid) t2 on t1.msgid = t2.msgid and t2.mydate = t1.date group by msgid";
        $data = $DB->read($query);
        
        if(is_array($data)){
          return $data[0];
        }
       return false;
    }
    
    public function read_one($id){
        $id = (int)$id;
        $DB = new Database();
        $me = esc($_SESSION['star_userid']); 
         
        $query = "select * from message where ((sender = '$me'  && receiver = '$userid') && deleted_sender = 0) ||  ((receiver = '$me'  && sender = '$userid') && deleted_receiver = 0) limit 1";
        $data = $DB->read($query);
    
    if(is_array($data)){
        
          return $data[0];
        }
        
        return false;
    }
    
    public function delete_one($id){
        
        $id = (int)$id;
        $DB = new Database();
        $me = esc($_SESSION['star_userid']); 
         
        $query = "select * from messages where (sender = '$me' || receiver = '$me' ) && id = '$id' limit 1";
        $data = $DB->read($query);
    
    if(is_array($data)){
        
            $data = $data[0];
            if($data['sender'] == $me)
            {
               $query = "update messages set deleted_sender = 1  where  id = '$id' limit 1";
            }else{
            
               $query = "update messages set deleted_recevier = 1  where  id = '$id' limit 1";
            }
        $DB->save($query);
        }
        
        return false;
    }
    
    public function delete_one_thread($msgid){
        
        $id = esc($msgid);
        
        $DB = new Database();
        $me = esc($_SESSION['star_userid']); 
         
        $query = "select * from messages where (sender = '$me' || receiver = '$me' ) && msgid = '$id' ";
        $data = $DB->read($query);
    
    if(is_array($data)){
        
        foreach ($data as $row) {
           #code...
                $myid = $row['id'];
                if($row['sender'] == $me)
                {
                   $query = "update messages set deleted_sender = 1  where  id = '$myid' limit 1";
                }else{

                   $query = "update messages set deleted_recevier = 1  where  id = '$myid' limit 1";
                }
            $DB->save($query);
            }
        }
        
        return false;
    }
    
   private function create_msgid($length){
        
        $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','
                       n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','-','_');
        $text = "";
        
        $length = rand(4,$length);
        
        for($i = 0; $i < $length; $i++){
            
            $random = rand(0,63);
            $text .= $array[$random];
        }
        
        return $text;
      }
 }
