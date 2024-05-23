<?php
session_start();

// Include necessary files and initialize database connection
require "mail.php";
include "classes/functions.php";

// Check if the user is logged in
function check_login() {
    if (!isset($_SESSION['USER'])) {
        // Redirect the user to the login page or display an error message
        header("Location: login.php");
        exit;
    }
}

// Check if the user is verified
function check_verified() {
    // Check if the 'email_verified' flag is set for the user in the session
    return isset($_SESSION['USER']) && $_SESSION['USER']->email_verified;
}

// Function to run database queries
function database_run($query, $vars) {
    // Initialize your database connection
    $pdo = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute($vars);

    // Return the result set if any
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
$errors = array();

// Check if the request method is GET and the user is not verified
if ($_SERVER['REQUEST_METHOD'] == "GET" && !check_verified()) {
    // Send verification email
    $vars['code'] = rand(10000, 99999);
    $vars['expires'] = (time() + (60 * 10));
    $vars['email'] = $_SESSION['USER']->email;

    $query = "INSERT INTO verify (code, expires, email) VALUES (:code, :expires, :email)";
    database_run($query, $vars);

    $message = "Your code is " . $vars['code'];
    $subject = "Email verification";
    $recipient = $vars['email'];
    send_mail($recipient, $subject, $message);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if the user is not verified
    if (!check_verified()) {
        // Verify the code submitted by the user
        $query = "SELECT * FROM verify WHERE code = :code AND email = :email";
        $vars = array();
        $vars['email'] = $_SESSION['USER']->email;
        $vars['code'] = $_POST['code'];

        $row = database_run($query, $vars);

        if (is_array($row)) {
            $row = $row[0];
            $time = time();

            if ($row->expires > $time) {
                // Update user's verification status
                $id = $_SESSION['USER']->id;
                $query = "UPDATE users SET email_verified = 1 WHERE id = :id LIMIT 1";
                database_run($query, array(':id' => $id));

                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Code expired";
            }
        } else {
            $errors[] = "Wrong code";
        }
    } else {
        $errors[] = "You're already verified";
    }
}

// Output any errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}

