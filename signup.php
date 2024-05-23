<?php

  include("classes/connect.php");
  include("classes/signup.php");

  $first_name = "";
  $last_name = "";
  $gender = ""; 
  $email = "";
  $password = ""; 
  $password = ""; 

  if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
    
     $signup = new Signup();
     $result = $signup->evaluate($_POST);

    if($result != "")
    {
            
        echo "<div style='text-align:center;font-size:12px;color:white;background:red;'>";
        echo "<br>The following errors occured:<br><br>";
        echo $result;
        echo "</div>";
            
    }
      else
    {
          
        header("Location: login.php");
        die;
    
    }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = $_POST['password'];
            
   }
  

?>

<!DOCTYPE html>

<html>
<html lang="bn">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <title>Star ||Sign Up</title>
    <style>
        #bar {
            height: 100px;
            background-color: #16b000;
            color: #fff;
            padding: 4px;
            padding-right: 425px;
            border-radius: 4px;
        }

        #signup-button {
            background-color: #5bd043;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 30px;
            float: right;
        }

        #bar2 {
            background-color: #e9ebee;
            width: 600px;
            height: 580px;
            margin: auto;
            margin-top: 50px;
            padding: 10px;
            padding-top: 20px;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
        }
 
        #text {
            height: 40px;
            width: 300px;
            border-radius: 4px;
            border: solid 1px #ccc;
            padding: 4px;
            font-size: 14px;
        }

        #text1 {
            height: 40px;
            width: 242px;
            border-radius: 4px;
            border: solid 1px #ccc;
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

    </style>
</head>

<body style="font-family: times new roman; background-image: url(images/img.jpg);">
    <div id="bar">
        <div style="font-size: 40px;padding-left: 421px;" style="font-family: times new roman;">Star</div>
        <a href="login.php">
        <input type="submit" id="signup-button" value="Login" style="font-family: times new roman;">
</a>
    </div>
    <div id="bar2">
        <h3>Sign Up to Star</h3>
        <form method="post" action="">   
            <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First Name" style="font-family: times new roman;"><br><br>
            <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last Name" style="font-family: times new roman;"><br><br>
            <span>Gender<br></span>
            <select id="text" name="gender" style="font-family: times new roman;">
                <option <?php echo $gender ?>>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select><br><br>

            <input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Email Address or Phone Number" style="font-family: times new roman;"><br><br>
            <input value="<?php echo $password ?>" name="password" type="password" id="text" placeholder="Password" style="font-family: times new roman;"><br><br>
            <input value="<?php echo $password ?>" name="password2" type="password" id="text" placeholder="Retype Password" style="font-family: times new roman;"><br><br><br>
            <input type="checkbox" required><a href="terms_and_conditions.php" style="text-decoration: none;">* Terms & Conditions</a>
            <br><br>
            <input type="submit" id="button" value="Sign Up" style="font-family: times new roman;"><br><br>
        </form>
    </div>
</body>

</html>
