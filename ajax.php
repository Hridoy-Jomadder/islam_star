<?php

include("classes/autoload.php");

 $data = file_get_contents("php://input");
 if($data != ""){
    $data = json_decode($data, true);
}
if(isset($data->action) && $data->action == "star_post"){
    include"ajax/star.ajax.php";
}



