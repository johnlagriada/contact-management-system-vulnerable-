<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and sanitize inputs
    $username_input = htmlspecialchars(trim($_POST['username']));
    $password_input = $_POST['password']; // Keep password raw, it's hashed in the database

    // Hash the password input using MD5
    $hashed_password_input = md5($password_input); // MD5 hashing of the password

    // Query to find user by username or email
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username_input, $username_input); // Bind the username to both username and email field
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and passwords match
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($hashed_password_input === $user['password']) {  // MD5 comparison
            // Start the session and set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Debugging - Check if session variables are set
            echo "Session variables are set. User logged in.";
            
            // Redirect to main.php after successful login
            header("Location: main.php");
            exit(); // Always call exit after header redirection to stop further execution
        } else {
            $error = "Invalid login credentials";  // Generic error message
        }
    } else {
        $error = "Invalid login credentials";  // Generic error message
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Century Gothic;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; /* Add this to stack the logo and form vertically */
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 20px; /* Add some space between logo and form */
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            transition: border 0.3s ease;
        }

        .input-group input:focus {
            border-color: #007BFF;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #007BFF;
        }

        .error {
            color: #f44336;
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .signup-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .signup-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #007BFF;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 20px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Logo at the top of the page, adjusted upwards -->
    <img src="logo/1.png" alt="School Logo" class="logo" alt="School Logo" style="max-width: 200px; display: block; margin: -40px auto 20px auto;">

    <div class="login-container">
        <h2>Login</h2>

        <!-- Display error if there's any -->
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="forgot-password">
            <p><a href="forgot_password.php">Forgot Password?</a></p>
        </div>

        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
        </div>
    </div>

</body>
</html>
