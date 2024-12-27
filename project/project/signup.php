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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists, show an error
        $error = "Username or email already exists!";
    } else {
        // Hash the password using MD5 for security (not recommended for production)
        $hashed_password = md5($password); // MD5 hashing of the password

        // Insert the new user into the database
        $insert_sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        
        if ($insert_stmt) {
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                // Set session message for successful account creation
                $_SESSION['success_message'] = "Account created successfully! You can now log in.";

                // Redirect to login page after successful registration
                header("Location: login.php");
                exit(); // Always call exit after header redirection
            } else {
                $error = "There was an error while creating your account!";
            }

            // Close the insert statement
            $insert_stmt->close();
        } else {
            $error = "Failed to prepare the statement!";
        }
    }

    // Close the select statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
            flex-direction: column; /* Added to make the logo appear above the form */
        }

        /* Logo outside the container */
        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 400px; /* Adjust the logo size */
            height: auto;
        }

        .signup-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
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
            .signup-container {
                padding: 20px;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>

    <!-- Logo placed outside the container -->
    <div class="logo">
    <img src="logo/1.png" alt="School Logo" class="logo" alt="School Logo" style="max-width: 200px; display: block; margin: -40px auto 20px auto;">

    </div>

    <div class="signup-container">
        <h2>Sign Up</h2>

        <!-- Display error if there's any -->
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

</body>
</html>
