<?php
session_start();

// Database connection setup (XAMPP)
$host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Set your MySQL password if applicable
$db_name = 'house_price';

// Create a new MySQL connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Capture username from the session before destroying it
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Insert logout time into the 'logout' table
    $logout_time = date('Y-m-d H:i:s');
    $insert_logout_sql = "INSERT INTO logout (username, logout_time) VALUES ('$username', '$logout_time')";

    if ($conn->query($insert_logout_sql) === false) {
        // Debugging message in case of query failure
        die('Error with logout insert: ' . $conn->error);
    }
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Close the database connection
$conn->close();

// Redirect to the login page
header("Location: ../login/login.php");
exit();
?>
