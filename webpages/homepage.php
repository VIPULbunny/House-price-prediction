<?php
session_start();

// Commenting out the session check for debugging purposes.
// Uncomment this once your login system is working properly.
// if (!isset($_SESSION['username'])) {
//     header("Location: ./login/login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Price Prediction</title>
    <link rel="stylesheet" href="homepage.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .centered-content {
            background-color: rgba(255, 255, 255, 0.8);
            margin: 50px auto;
            padding: 20px;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .auth-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .auth-buttons a {
            text-decoration: none;
        }

        .auth-buttons button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .auth-buttons button:hover {
            background-color: #0056b3;
        }

        /* Additional styles for form elements */
        .filters {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select, input[type="range"], button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        /* Styling the "Give local data" button to be smaller and next to the auth buttons */
        .local-data-btn {
            padding: 8px 12px;
            background-color: #ff5722;
            color: white;
            border: none;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .local-data-btn:hover {
            background-color: #e64a19;
        }

        /* Adjust alignment of auth-buttons to be on the right side */
        .auth-container {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
    </style>
</head>
<body>

    <!-- Centered Content -->
    <div class="centered-content">
        <!-- Header Section -->
<header>
    <h1>House Price Prediction</h1>
    <div class="auth-container">
        <!-- Auth Buttons -->
        <div class="auth-buttons">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="../webpages/login/login.php"><button id="login-btn">Login</button></a>
                <a href="../webpages/sign-up/index.html"><button id="signup-btn">Signup</button></a>
            <?php else: ?>
                <a href="../webpages/login/logout.php"><button id="logout-btn">Logout</button></a>
            <?php endif; ?>
        </div>

        <!-- "Give Local Data" Button -->
        <a href="../webpages/localdata/submit_form.php"><button class="local-data-btn">Submit Property Data</button></a>
    </div>
</header>


        <!-- Filter Section -->
        <section class="filters">
            <h2>Filter Properties</h2>
            <form id="filter-form" action="http://127.0.0.1:5000/" method="POST">
    <!-- BHK Filter -->
    <label for="bhk">BHK:</label>
    <select id="bhk" name="bhk">
        <option value="2">2 BHK</option>
        <option value="3">3 BHK</option>
    </select>

    <!-- Type Filter -->
    <label for="type">Type:</label>
    <select id="type" name="type">
        <option value="apartment">Apartment</option>
        <option value="villa">Villa</option>
        <option value="penthouse">Penthouse</option>
        <option value="bungalow">Bungalow</option>
        <option value="studio">Studio</option>
    </select>

    <!-- Region Filter -->
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

    <!-- Status Filter -->
    <label for="status">Status:</label>
    <select id="status" name="status">
        <option value="ready">Ready to Move</option>
        <option value="under-construction">Under Construction</option>
    </select>

    <!-- Age Filter -->
    <label for="age">Age:</label>
    <select id="age" name="age">
        <option value="new">New</option>
        <option value="resale">Resale</option>
    </select>

    <!-- Submit Button -->
    <button type="submit">Apply Filters</button>
</form>

        </section>
    </div>

</body>
</html>
