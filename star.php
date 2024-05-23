<?php 
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";


include"classes/autoload.php";

	$login = new Login();
	$user_data = $login->check_login($_SESSION['star_userid']);

 
if(isset($_SERVER['HTTP_REFERER'])){

	$return_to = $_SERVER['HTTP_REFERER'];
}else{
	$return_to = "profile.php";
}
//check last update

$_GET['type'] = isset($_GET['type']) ? $_GET['type'] : null;
$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : null;

	if(isset($_GET['type']) && isset($_GET['id'])){
		
		if(is_numeric($_GET['id'])){

			$allowed[] = 'post';
			$allowed[] = 'user';
			$allowed[] = 'comment';

			if(in_array($_GET['type'], $allowed)){

				$post = new Post();
				$user_class = new User();
				$post->star_post($_GET['id'],$_GET['type'],$_SESSION['star_userid']);

				if($_GET['type'] == "user"){
					$user_class->follow_user($_GET['id'],$_GET['type'],$_SESSION['star_userid']);
				}
			}

		}
		
	}


header("Location: ". $return_to);
die;