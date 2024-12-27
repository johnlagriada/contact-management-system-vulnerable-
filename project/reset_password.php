<?php
session_start();
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $reset_token = $_GET['token'];

    // Validate if both passwords match
    if ($new_password === $confirm_password) {
        // Hash the new password (Use a better hashing method like bcrypt in production)
        $hashed_password = md5($new_password); 

        // Check if the token exists and is not expired
        $sql = "SELECT user_id, reset_token_expiry FROM password_resets WHERE reset_token = ? AND reset_token_expiry > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $reset_token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Token is valid, update the password
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];

            // Update the user's password
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();

            // Remove the reset token from the password_resets table (so it can't be reused)
            $sql = "DELETE FROM password_resets WHERE reset_token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $reset_token);
            $stmt->execute();

            echo "Your password has been reset successfully.";
            header("Location: login.php"); // Redirect to login page after reset
            exit;
        } else {
            echo "Invalid or expired token.";
        }

        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>

    <h2>Reset Password</h2>

    <form method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="submit">Reset Password</button>
    </form>

</body>
</html>
