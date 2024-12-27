<?php
// Database connection settings
$servername = "localhost"; // Your database host, typically 'localhost'
$username = "root";        // Your database username
$password = "";            // Your database password (leave blank if no password)
$dbname = "contact_management";           // Your database name (replace with your actual database name)

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
