<?php 
session_start();
$error = array();

require "mail.php";

	if(!$con = mysqli_connect("localhost","root","","star_db1")){

		die("could not connect");
	}

	$mode = "enter_email";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	//something is posted
	if(count($_POST) > 0){

		switch ($mode) {
			case 'enter_email':
				// code...
				$email = $_POST['email'];
				//validate email
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					$error[] = "Please enter a valid email";
				}elseif(!valid_email($email)){
					$error[] = "That email was not found";
				}else{

					$_SESSION['forgot']['email'] = $email;
					send_email($email);
					header("Location: forgot.php?mode=enter_code");
					die;
				}
				break;

			case 'enter_code':
				// code...
				$code = $_POST['code'];
				$result = is_code_correct($code);

				if($result == "the code is correct"){

					$_SESSION['forgot']['code'] = $code;
					header("Location: forgot.php?mode=enter_password");
					die;
				}else{
					$error[] = $result;
				}
				break;

			case 'enter_password':
				// code...
				$password = $_POST['password'];
				$password2 = $_POST['password2'];

				if($password !== $password2){
					$error[] = "Passwords do not match";
				}elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
					header("Location: forgot.php");
					die;
				}else{
					
					save_password($password);
					if(isset($_SESSION['forgot'])){
						unset($_SESSION['forgot']);
					}

					header("Location: login.php");
					die;
				}
				break;
			
			default:
				// code...
				break;
		}
	}

	function send_email($email){
		
		global $con;

		$expire = time() + (60 * 1);
		$code = rand(10000,99999);
		$email = addslashes($email);

		$query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
		mysqli_query($con,$query);

		//send email here
		send_mail($email,'Password reset',"Your code is " . $code);
	}
	
	function save_password($password){
		
		global $con;
        
        $password = ("$password"); //Add new line
//		$password = password_hash($password, PASSWORD_DEFAULT);
        
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "update users set password = '$password' where email = '$email' limit 1";
		mysqli_query($con,$query);

	}
	
	function valid_email($email){
		global $con;

		$email = addslashes($email);

		$query = "select * from users where email = '$email' limit 1";		
		$result = mysqli_query($con,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				return true;
 			}
		}

		return false;

	}

	function is_code_correct($code){
		global $con;

		$code = addslashes($code);
		$expire = time();
		$email = addslashes($_SESSION['forgot']['email']);

		$query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
		$result = mysqli_query($con,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				if($row['expire'] > $expire){

					return "the code is correct";
				}else{
					return "the code is expired";
				}
			}else{
				return "the code is incorrect";
			}
		}

		return "the code is incorrect";
	}

	
?>
<!DOCTYPE html>
<html>

<head>
    <title>Star | Forgot</title>
    <style>
        #bar {
            height: 100px;
            background-color: #16b000;
            color: white;
            padding: 4px;
            padding-right: 425px;
        }

        #signup-button {
            background-color: #42b72a;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 30px;
            float: right;
        }

        #bar2 {
            background-color: white;
            width: 800px;
            height: 400px;
            margin: auto;
            margin-top: 50px;
            padding: 10px;
            padding-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        #text {
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border: solid 1px #16b000;
            padding: 4px;
            font-size: 14px;
        }

        #button {
            width: 300px;
            height: 40px;
            border-radius: 4px;
            font-weight: bold;
            border: none;
            background-color: #16b000;
            color: white;
        }

        #box {}

        #box a {
            text-decoration: none;
        }

    </style>
</head>

<body style="font-family: times new roman; background-color: #e9ebee;">
    <div id="bar">
        <div style="font-size: 40px;padding-left: 421px;">Star</div>
    </div>
    <div id="bar2">
        <span> Go with the stars, explore the world. </span> <br><br>
        <?php 

			switch ($mode) {
				case 'enter_email':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_email"> 
							<span>Forgot Password</span><br><br>
							<span>Enter your email below</span><br><br>
							<span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>
							<input id="text" type="email" name="email" placeholder="Email Address"><br>
							<br style="clear: both;">
							<input id="button" type="submit" value="Next">
							<br><br>
						</form>
					<?php				
					break;

				case 'enter_code':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_code"> 
							<span>Forgot Password</span><br><br>
							<span>Enter your the code sent to your email</span><br><br>
							<span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input id="text"  type="text" name="code" placeholder="12345"><br>
							<br style="clear: both;">
							<input id="button" type="submit" value="Next" style="float: right;">
							<a href="forgot.php">
								<input id="button" type="button" value="Start Over">
							</a>
							<br><br>
						</form>
					<?php
					break;

				case 'enter_password':
					// code...
					?>
						<form method="post" action="forgot.php?mode=enter_password"> 
							<span>Forgot Password</span><br><br>
							<span>Enter your new password</span><br><br>
							<span style="font-size: 12px;color:red;">
							<?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
							</span>

							<input id="text" type="text" name="password" placeholder="Password"><br><br>
							<input id="text" type="text" name="password2" placeholder="Retype Password"><br>
							<br style="clear: both;">
							<input id="button" type="submit" value="Next" style="float: right;">
							<a href="forgot.php">
								<input id="button" type="button" value="Start Over">
							</a>
						</form>
					<?php
					break;
				
				default:
					// code...
					break;
			}

		?>

    </div>
    
</body>

</html>

		


