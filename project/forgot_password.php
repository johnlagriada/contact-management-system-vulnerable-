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
    $username_or_email = $_POST['username_or_email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password using MD5
        $hashed_password = md5($new_password); // MD5 hashing of the password

        // Query to get the user by username or email
        $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            // If preparation fails, display an error and exit
            die('MySQL prepare error: ' . $conn->error);
        }

        $stmt->bind_param("ss", $username_or_email, $username_or_email); // Bind the username or email
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, get the user ID
            $user = $result->fetch_assoc();
            $user_id = $user['id'];

            // Query to update the password in the database
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                // If preparation fails, display an error and exit
                die('MySQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param("si", $hashed_password, $user_id); // Bind the hashed password and user ID
            $stmt->execute();

            // Insert the password reset record into the password_resets table
            $reset_token = bin2hex(random_bytes(32)); // Generate a secure reset token
            $reset_token_expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Set expiry for the token (1 hour)

            $sql = "INSERT INTO password_resets (user_id, reset_token, created_at) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                // If preparation fails, display an error and exit
                die('MySQL prepare error: ' . $conn->error);
            }

            $stmt->bind_param("iss", $user_id, $reset_token, $reset_token_expiry);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Success message
                $success_message = "Your password has been successfully updated and recorded in the reset log.";
            } else {
                // Error message
                $error_message = "Failed to record the password reset. Please try again.";
            }

        } else {
            // Error message if user not found
            $error_message = "No user found with that username or email.";
        }

        $stmt->close();
    } else {
        $error_message = "The new password and confirmation password do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
            flex-direction: column; /* Stack the logo and form vertically */
        }

        .change-password-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 20px; /* Add space between logo and form */
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

        .success {
            color: #4CAF50;
            text-align: center;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .change-password-container {
                padding: 20px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Logo at the top of the page -->
    <img src="logo/1.png" alt="School Logo" class="logo" style="max-width: 200px; display: block; margin: -40px auto 20px auto;"> 

    <div class="change-password-container">
        <h2>Change Password</h2>

        <!-- Display error or success message -->
        <?php if (isset($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php elseif (isset($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="username_or_email">Username or Email</label>
                <input type="text" id="username_or_email" name="username_or_email" required>
            </div>
            <div class="input-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Change Password</button>
        </form>

        <div class="login-link">
            <p>Remembered your password? <a href="login.php">Login here</a></p>
        </div>
    </div>

</body>
</html>
