<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ./login/login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "house_price";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $bhk = $_POST['bhk'];
    $type = $_POST['type'];
    $region = $_POST['region'];
    $status = $_POST['status'];
    $age = $_POST['age'];
    $price = $_POST['price'];
    $price_unit = $_POST['price_unit'];

    // SQL query to insert data into the database
    $sql = "INSERT INTO properties (bhk, type, region, status, age, price, price_unit)
            VALUES ('$bhk', '$type', '$region', '$status', '$age', '$price', '$price_unit')";

    if ($conn->query($sql) === TRUE) {
        echo "Property data has been submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Property Data</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .centered-content {
            background-color: rgba(255, 255, 255, 0.9);
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        select, input[type="text"], input[type="number"], button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="centered-content">
        <h2>Submit Property Data</h2>
        <form method="POST" action="submit_form.php">
            <!-- BHK -->
            <label for="bhk">BHK:</label>
            <select id="bhk" name="bhk">
                <option value="2">2 BHK</option>
                <option value="3">3 BHK</option>
            </select>

            <!-- Type -->
            <label for="type">Type:</label>
            <select id="type" name="type">
                <option value="apartment">Apartment</option>
                <option value="villa">Villa</option>
                <option value="penthouse">Penthouse</option>
                <option value="bungalow">Bungalow</option>
                <option value="studio">Studio</option>
            </select>

            <!-- Region -->
            <label for="region">Region:</label>
            <select id="region" name="region">
                <option value="andheri">Andheri</option>
                <option value="badlapur">Badlapur</option>
                <option value="thane">Thane</option>
                <option value="bandra">Bandra</option>
                <option value="borivali">Borivali</option>
                <option value="dadar">Dadar</option>
                <option value="goregaon">Goregaon</option>
                <option value="juhu">Juhu</option>
                <option value="kandivali">Kandivali</option>
                <option value="mulund">Mulund</option>
                <option value="nerul">Nerul</option>
                <option value="vikhroli">Vikhroli</option>
            </select>

            <!-- Status -->
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="ready">Ready to Move</option>
                <option value="under-construction">Under Construction</option>
            </select>

            <!-- Age -->
            <label for="age">Age:</label>
            <select id="age" name="age">
                <option value="new">New</option>
                <option value="resale">Resale</option>
            </select>

            <!-- Price -->
            <label for="price">Price (in numbers):</label>
            <input type="number" id="price" name="price" min="0" placeholder="Enter price" required>

            <!-- Price Unit -->
            <label for="price_unit">Price Unit:</label>
            <select id="price_unit" name="price_unit">
                <option value="lacs">Lacs</option>
                <option value="cr">Cr</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
