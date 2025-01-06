<?php
// XAMPP MySQL connection setup
$host = "localhost";
$username = "root";
$password = ""; // Your MySQL root password
$dbname = "house_price"; // Database name

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    // SQL query to insert the data
    $sql = "INSERT INTO signup (username, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        // If registration is successful, redirect to login page
        header("Location: ../login/login.php");
        exit(); // Make sure no more code is executed after the redirect
    } else {
        // If there is an error, store the error message
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
