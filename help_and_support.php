<?php 

include"classes/autoload.php";

$login = new Login();
$user_data = $login->check_login($_SESSION['star_userid']);

$USER = $user_data;

if(isset($_GET['id']) && is_numeric($_GET['id'])){

    $profile = new Profile();
    $profile_data = $profile->get_profile($_GET['id']);

   if(is_array($profile_data)){
    $user_data = $profile_data[0];
  }
}

?>

<!DOCTYPE html>
<html>
<html lang="bn">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<head>
    <title>Help and Support|| Star</title>
    <style>
        #bar {
            height: 100px;
            background-color: #16b000;
            color: #fff;
            padding: 4px;
            padding-right: 425px;
            border-radius: 4px;
        }

        #button {
            background-color: #5bd043;
            width: 70px;
            text-align: center;
            padding: 4px;
            border-radius: 30px;
            float: right;
        }

        #bar2 {
            background-color: #e9ebee;
            height: 600px;
            margin-top: 10px;
            padding: 10px;
            font-weight: bold;
            border-radius: 4px;
        }

    </style>
</head>

<body style="font-family: times new roman; background-image: url(images/img.jpg);">
    <div id="bar">
        <div style="font-size: 40px;padding-left: 421px;" style="font-family: times new roman;">Star</div>
        <a href="index.php">
            <input type="submit" id="button" value="Back to Star" style="font-family: times new roman;width: 100px;">
        </a>
    </div>
    <div id="bar2">
<div style="min-height: 450px; width: 80%; max-width: 800px; margin: 0 auto; background-color: #fff; text-align: center; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <h3 style="text-align: center; color: white; text-shadow: 1px 1px 2px green, 0 0 5px darkblue;">Help and Support</h3>
  <form method="post" enctype="multipart/form-data">
        <input type='text' style='display: block; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;' name='first_name' value='' placeholder='Full Name'>
        <input type='text' style='display: block; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;' name='address' value='' placeholder='Address'>
        <input type='text' style='display: block; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;' name='email' value='' placeholder='E-mail Address'>
        <textarea style='display: block; min-height: 200px; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;' name='about' placeholder='Help and Support'></textarea>
        <input type="file" style='display: block; width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;' name='file' value='' enctype="multipart/form-data">
        <input type="submit" style="background-color: #5bd043; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;" value="Send">
    </form>
</div>

    </div>
</body>

</html>
