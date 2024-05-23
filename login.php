<?php

session_start();

  include("classes/connect.php");
  include('classes/login.php');

  $email = "";
  $password = ""; 

  if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
    
        $login = new Login();
        $result = $login->evaluate($_POST);
     
    if($result != "")
        {

            echo "<div style='text-align:center;font-size:12px;color:white;background:red;'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";

        }else
        {

            header("Location: index.php");
            die;

        }

        $email = $_POST['email'];
        $password = $_POST['password'];
       
   }
  

?>
<!DOCTYPE html>
<html>

<head>
    <title>Star | Log in</title>
    <style>
        #bar {
            height: 100px;
            background-color: #16b000;
            color: white;
            /*            padding: 4px;*/
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
            background-color: white;
            width: 510px;
            height: 400px;
            margin: auto;
            margin-top: 50px;
            padding: 10px;
            padding-top: 50px;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;

        }

        #input{
            background-color: white;
            border: solid 1px #16b000;
            border-radius: 4px;
        } 

        #text {
            height: 40px;
            width: 300px;
            
            
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

        #box {
            color: black;
        }

        #box a {
            text-decoration: none;
        }

    </style>
</head>

<body style="font-family: times new roman; background-color: #32CD32; ">
<!-- background-image: url(images/img.jpg); -->
    <div id="bar">
        <div style="font-size: 40px;padding-left: 421px;">Star</div>
        <form method="" action="signup.php">
            <input type="submit" id="signup-button" value="Sign Up" style="font-family: times new roman;">
        </form>
    </div>
    <div id="bar2">
        <h2> Go with the stars, explore the world. </h2>
        <span>Log in to Star</span> <br><br>
        <form action="" method="POST">
            <input class="input" name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email Address or Phone Number" style="font-family: times new roman;"><br><br>
            <input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password" style="font-family: times new roman;"><br><br><br>
            <!-- <input type="checkbox" required>Remember Me<br><br> -->

            <input type="submit" id="button" value="Log in" style="font-family: times new roman;"><br><br>
        </form>
        <div id="box">
            <a href="forgot.php">
                <h4 style="color: black;">Forgotten password?</h4>
            </a>
        </div>
    </div>

</body>

</html>
