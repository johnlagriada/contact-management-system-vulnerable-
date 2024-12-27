<?php
// Include database connection
include('db.php');

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from POST request
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $tags = $_POST['tags'];
    $zip_code = $_POST['zip_code'];

    // Validate input (basic example)
    if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($zip_code)) {
        echo "Please fill all required fields.";
        exit;
    }

    // SQL query to insert data into the database
    $query = "INSERT INTO contacts (name, phone, email, address, birthday, tags, zip_code) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    
    // Bind parameters to prevent SQL injection
    $stmt->bind_param("sssssss", $name, $phone, $email, $address, $birthday, $tags, $zip_code);

    // Execute the query
    if ($stmt->execute()) {
        echo "Contact added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
