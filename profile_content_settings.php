<div style="min-height: 400px; width:100%; background-color: white; text-align: center;">
    <div style="padding: 20px; max-width:450px; display: inline-block;">
        <br>
        <br>
        <form method="post" enctype="multipart/form-data">
            <?php
            $settings_class = new Settings();
            $settings = $settings_class->get_settings($_SESSION['star_userid']);
            
            if(is_array($settings)) { 
                // Check if the user has permission to edit
                $edit_permission = true; // Assuming the user has permission by default
                
                // Check if the current user is the owner of the profile
                if ($_SESSION['star_userid'] != $settings['userid']) {
                    // If not the owner, check if the current user has special edit permissions (e.g., admin)
                    // Set $edit_permission to true or false based on the user's role or other criteria
                }
                
                echo "<input type='text' class='textbox' name='first_name' value='" . htmlspecialchars($settings['first_name']) . "' placeholder='First Name' />";
                echo "<input type='text' class='textbox' name='last_name' value='" . htmlspecialchars($settings['last_name']) . "' placeholder='Last Name' />";
                echo "<input type='text' class='textbox' name='title' value='" . htmlspecialchars($settings['title']) . "' placeholder='Title' />";
                                // New fields for school, college and university
                                echo "<input type='text' class='textbox' name='school' value='" . htmlspecialchars($settings['school']) . "' placeholder='school' />";
                                echo "<input type='text' class='textbox' name='college' value='" . htmlspecialchars($settings['college']) . "' placeholder='College' />";
                                echo "<input type='text' class='textbox' name='university' value='" . htmlspecialchars($settings['university']) . "' placeholder='University' />";
                
                                // New fields for url
                                echo "<input type='text' class='textbox' name='url' value='" . htmlspecialchars($settings['url']) . "' placeholder='Website URL' />";
                
                // echo "<select class='textbox' name='gender'>
                //         <option value='Male' " . ($settings['gender'] == 'Male' ? 'selected' : '') . ">Male</option>
                //         <option value='Female' " . ($settings['gender'] == 'Female' ? 'selected' : '') . ">Female</option>
                //         <option value='Other' " . ($settings['gender'] == 'Other' ? 'selected' : '') . ">Other</option>
                //       </select>";
                echo "<input type='text' class='textbox' name='email' value='" . htmlspecialchars($settings['email']) . "' placeholder='E-mail Address' />";
                echo "<input type='password' class='textbox' name='password' placeholder='Password' />";
                echo "<input type='password' class='textbox' name='password2' placeholder='Re-type password' />";
                echo "<br> About Me: <br>
                      <textarea class='textbox' style='height:200px;' name='about'>" . htmlspecialchars($settings['about']) . "</textarea>";



                echo '<input class="post_button" type="submit" value="Save">';
            }
            ?>
        </form>
    </div>
</div>

<style>
  .textbox {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

.post_button {
    background-color: #16b000;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.post_button:hover {
    background-color: #0e8000;
}
</style>
