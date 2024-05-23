<div style="min-height: 700px; width:100%; background-color: white; text-align: center;">
    <div style="padding: 20px;">
       <h3>Photos</h3>
        <?php

            $DB = new Database();
            $sql = "select image,postid from posts where has_image = 1 &&  userid = $user_data[userid] order by id desc limit 30";
            $images = $DB->read($sql);

            $image_class = new Image();
     
            if(is_array($images)){

                foreach($images as $image_row) {
                    #code...
                    echo "<a href='single_post.php?id=$image_row[postid]' >";
                    echo "<img src='" . $image_class->get_thumb_post($image_row['image']) . "' style='width:200px;height:200px;float:left;padding: 8px; border-radius: 12px;' />";
                    echo "</a>";

                }

              }else{

                echo "No images were found!";
             }
        ?>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</div>
