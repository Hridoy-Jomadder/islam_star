<?php

session_start();

if(isset($_SESSION['star_userid']))
{
    
  $_SESSION['star_userid'] = NULL;
  unset($_SESSION['star_userid']);

}

header("Location: login.php");
die;























