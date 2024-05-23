<?php 

    include"classes/autoload.php";

  $login = new Login();
  $user_data = $login->check_login($_SESSION['star_userid']);
  
  $USER = $user_data;

    if(isset($_GET['find'])){

        $find = addslashes($_GET['find']);
            
        $sql = "select * from users where first_name LIKE '%$find%' || last_name LIKE '%$find%' limit 30";
        $DB = new Database();
        $results = $DB->read($sql);
        
        }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>People who Star | Star</title>
    <style>
        #blue_bar {
            height: 60px;
            background-color: #16b000;
            color: #d9dfeb;
        }

        #search_box {
            width: 40%;
            padding: 4px;
            font-size: 14px;
            background-image: url(images/search.png);
            background-repeat: no-repeat;
            background-position: right;
        }

        #profile_pic {
            width: 300px;
            margin-top: -320px;
            border: solid 5px red;
        }

        #menu_buttons {
            width: 100px;
            display: inline-block;
            margin: 2px;

        }

        #menu_buttons a {
            text-decoration: none;
        }

        #friends_img {
            width: 70px;
            float: left;
            margin: 8px;
        }

        #friends_bar {
            background-color: #ffffff;
            min-height: 400px;
            margin-top: 20px;
            color: black;
            text-align: center;
        }

        #friends {
            clear: both;
            font-size: 12px;
            font-weight: bold;
            color: #405d9b;
            padding: 8px;
        }

        #textarea {
            width: 100%;
            border: none;
            font-family: times new roman;
            font-size: 14px;
            height: 50px;
        }

        #post_button {
            float: right;
            background-color: #405d9b;
            border: none;
            color: white;
            padding: 4px;
            font-size: 14px;
            border-radius: 2px;
            width: 50px;
        }

        #post_bar {
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }

        #post {
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }

        #See_More {
            background-color: #405d9b;
            border: inset;
            color: white;
            padding: 4px;
            font-size: 14px;
            border-radius: 18px;
            width: 82px;
            float: right;
        }

    </style>
</head>

<body style="font-family: times new roman; background-color: #d0d8e4;">

    <!-- header-->
    <?php include"header.php"; ?>

    <!--cover area-->
    <div style="width: 1300px; margin: auto; min-height: 400px;">

        <!--  below  cover area-->
        <div style="display: flex;">
            <!--    Post area-->
            <div style="min-height: 400px; flex: 2.5; padding: 40px; padding-left: 0px;">
                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                    <h2>Search Box Result</h2><br>
                    <div style="display: inline-block;">
                        <!-- <h3> Public</h3>
                        <h3> Post</h3>
                        <h3> Public</h3>
                        <h3> Public</h3> -->
                    </div>



                    <?php 

                           $User = new User();
                           $image_class = new Image();   

                         if(is_array($results)){

                             foreach ($results as $row) {
                                     # code...
                                     $FRIEND_ROW = $User->get_user($row['userid']);
                                     include("user.php");
                                 }
                             }else{

                             echo "No results were found";
                           }

                         ?>

                    <br style="clear: both;">
                </div>

            </div>
        </div>

    </div>
</body>

</html>
