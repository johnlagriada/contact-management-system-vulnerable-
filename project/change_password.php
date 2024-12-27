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
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password
        $hashed_password = md5($new_password); // MD5 hashing of the password

        // Get the user ID from session (you could also implement a token check for password reset)
        $user_id = $_SESSION['user_id'];

        // Query to update the password in the database
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $user_id); // Bind the password and user ID
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Success message
            $success_message = "Your password has been successfully updated.";
        } else {
            // Error message
            $error_message = "Failed to update password. Please try again.";
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
