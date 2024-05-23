<?php

// Define the Video class
class Video {
    private $db;

    // Constructor to initialize the database connection
    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'star_db1');
        if ($this->db->connect_error) {
            die('Connection failed: ' . $this->db->connect_error);
        }
    }

    // Function to get all videos from the database
    public function getAllVideos() {
        $query = "SELECT * FROM videos";
        $result = $this->db->query($query);

        $videos = array(); // Array to store video data

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $video = array(
                    'video' => $row['video'],
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'tag' => $row['tag'],
                    'upload_date' => $row['upload_date']
                );
                $videos[] = $video; // Add video data to the array
            }
        }

        return $videos;
    }

    // Function to add a new video to the database
    public function addVideo($video, $title, $description, $tag, $url) {
        // Create an instance of the User class
        $user = new User();
        
        // Retrieve the user ID using the getUserID() method from the User class
        $userID = $user->getUserID($_SESSION['star_userid']);
    
        $query = "INSERT INTO videos (userid, video, title, description, tag, url) VALUES ('$userID', '$video', '$title', '$description', '$tag', '$url')";
        if ($this->db->query($query) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
    

    // Function to handle file upload
    public function uploadVideo($file, $targetDir) {
        $targetFile = $targetDir . basename($file["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
    
        // Check file size
        if ($file["size"] > 1000000000) { // Limit to 1GB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if ($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov" && $videoFileType != "wmv") {
            echo "Sorry, only MP4, AVI, MOV, and WMV files are allowed.";
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                return $targetFile; // Return the file path if upload is successful
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    public function getUserVideos($userID) {
        $query = "SELECT * FROM videos WHERE userid = '$userID'";
        $result = $this->db->query($query);
    
        $videos = array(); // Array to store video data
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $videos[] = $row; // Add video data to the array
            }
        }
    
        return $videos;
    }
    
}

// Usage example
$video = new Video();

// Check if a video is being added

if (isset($_POST['submit'])) {
    $videoFile = $_FILES['videoFile'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];

    // Upload the video file
$uploadedFile = $video->uploadVideo($videoFile, 'videos/');

if ($uploadedFile) {
    // Generate a unique identifier for the video (e.g., UUID)
    $uniqueID = uniqid();

    // URL for the video can be based on the unique identifier
    $url = "http://localhost/StarShort/profile.php?section=videos&id=$uniqueID";

    // Add the video to the database
    $added = $video->addVideo($uploadedFile, $title, $description, $tag, $url);

    if ($added) {
        echo "Video added successfully.";
    } else {
        echo "Error adding video.";
    }
 }

}



