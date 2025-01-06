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

// Initialize error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username/email exists in the 'signup' table
    $sql = "SELECT * FROM signup WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    if ($result === false) {
        // Debugging message in case of query failure
        die('Error with the query: ' . $conn->error);
    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Insert login details into the 'login' table
            $login_time = date('Y-m-d H:i:s');
            $insert_sql = "INSERT INTO login (username, login_time) VALUES ('$username', '$login_time')";
            
            if ($conn->query($insert_sql) === false) {
                // Debugging message in case of query failure
                die('Error with login insert: ' . $conn->error);
            }

            // Redirect to homepage after successful login
            header('Location: http://127.0.0.1:5000');
            exit();
        } else {
            $error_message = 'Invalid password!';
        }
    } else {
        $error_message = 'User not found!';
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli">
  <link rel="stylesheet" href="style.css"> <!-- Linking the external CSS file -->
</head>
<body>
  <div class="pt-5">
    <h1 class="text-center">Login</h1>
    <div class="container">
      <div class="row">
        <div class="col-md-5 mx-auto">
          <div class="card card-body">

            <!-- Display error message if login fails -->
            <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <!-- Login Form -->
            <form id="submitForm" action="login.php" method="post">
              <div class="form-group required">
                <label for="username">Username / Email</label>
                <input type="text" class="form-control text-lowercase" id="username" name="username" required>
              </div>
              <div class="form-group required">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group mt-4 mb-4">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="remember-me" name="remember-me">
                  <label class="custom-control-label" for="remember-me">Remember me?</label>
                </div>
              </div>
              <div class="form-group pt-1">
                <button class="btn btn-primary btn-block" type="submit">Log In</button>
              </div>
            </form>

            <!-- Sign-up link -->
            <p class="small-xl pt-3 text-center">
              <span class="text-muted">Not a member?</span>
              <a href="../sign-up/index.html">Sign up</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
