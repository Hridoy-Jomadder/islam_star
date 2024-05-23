<div style="min-height: 700px; width:100%; background-color: white; text-align: center;">
    <div style="padding: 20px;">
        <h1>All Videos</h1>

        <?php
            $user = new User();
            $userID = $user->getUserID($_SESSION['star_userid']);

            // Check if the user is logged in and session variable is set
            if (isset($_SESSION['star_userid'])) {
                
            // Get the user ID from the session
            $userID = $_SESSION['star_userid'];
            } else {
                // Redirect the user to the login page or handle the situation appropriately
                header("Location: profile.php");
                exit(); // Stop further execution
            }

        // Get the user ID from the user class
        $id = esc($_SESSION['star_userid']);

        // Check if a video is being added
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['videoFile'])) {
            $videoFile = $_FILES['videoFile'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $tag = $_POST['tag'];

            // Check if a file was selected
            if ($videoFile['error'] !== UPLOAD_ERR_OK) {
                echo "Please select a video file.";
            } else {
                // Move the uploaded video file to a desired location
                $targetDirectory = 'videos/';
                $targetFile = $targetDirectory . basename($videoFile['name']);

                // Check if the uploaded file is a valid video file
                $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $allowedTypes = array("mp4", "avi", "mov", "wmv");

                if (!in_array($videoFileType, $allowedTypes)) {
                    echo "Sorry, only MP4, AVI, MOV, and WMV files are allowed.";
                } else {
                    if (move_uploaded_file($videoFile['tmp_name'], $targetFile)) {
                        // Add the video to the database
                        $added = $video->addVideo($userID,$videoFile['name'], $title, $description, $tag);
                        if ($added) {
                            echo "Video uploaded successfully.";
                        } else {
                            echo "Error adding video to the database.";
                        }
                    } else {
                        echo "Error uploading video.";
                    }
                }
            }
        }
        // Display existing videos for the current user
       $videos = $video->getUserVideos($userID);
        ?>

        <h2>Add New Video</h2>
        <form method="post" action="" enctype="multipart/form-data" class="form">
            <label for="videoFile">Video:</label>
            <input type="file" name="videoFile" accept="video/*" required><br>

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea><br>

            <label for="Tag">Tags:</label>
            <input type="text" name="tag" id="tag" required><br>

            <input type="submit" name="submit" value="Upload">
        </form>

        <?php
        // Display existing videos
        $videos = $video->getAllVideos();

        if (!empty($videos)) {
            echo '<div class="video-container">';
            foreach ($videos as $videoData) {
                echo '<div class="video-card">';
                echo '<video width="320" height="240" controls>';
                echo '<source src="' . $videoData['video'] . '" type="video/mp4">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
                echo '<h2 class="video-title">' . $videoData['title'] . '</h2>';
                echo '<p class="video-description">' . $videoData['description'] . '</p>';
                echo '<br/>';
                echo '<h2 class="video-tag">Tags: ' . $videoData['tag'] . '</h2>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo 'No videos found.';
        }
        ?>

<style>
    /* CSS styles for the form */
    .form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            max-width: 1350px;
            min-width: auto;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="file"],
        input[type="text"],
        textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        textarea {
            height: 100px; /* Set the height for textarea */
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .video-card {
            width: 320px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding-top: 0px;
            background-color: greenyellow;
        }

        .video-title {
            margin-top: 10px;
            font-size: 22px;
            
        }

        .video-description {
            margin-top: 5px;
            font-style: times new roman;
            max-height: 300px; /* Adjust the max height as needed */
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: justify;
        }

        .video-tag {
            margin-top: 5px;
            color: white;
            font-size: 14px;
        }
    </style>


        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</div>