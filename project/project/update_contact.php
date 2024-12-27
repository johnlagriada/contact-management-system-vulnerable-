<?php
// Include your database connection
include('db.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the request is a POST method and contains JSON data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $input = file_get_contents("php://input");

    // Decode the JSON data
    $data = json_decode($input, true);

    // Debugging: print the received data to the browser
    echo "<pre>";
    print_r($data);  // This will show you the data sent from JavaScript
    echo "</pre>";

    // Check if the required fields are present
    if (isset($data['id'], $data['name'], $data['phone'], $data['email'], $data['address'], $data['birthday'], $data['tags'], $data['zip'])) {
        $id = $data['id'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $address = $data['address'];
        $birthday = $data['birthday']; // Expecting format 'YYYY-MM-DD'
        $tags = $data['tags'];
        $zip = $data['zip'];

        // Prepare the SQL query to update the contact
        $query = "UPDATE contacts SET name = ?, phone = ?, email = ?, address = ?, birthday = ?, tags = ?, zip_code = ? WHERE id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
            // Bind parameters
            $stmt->bind_param("sssssssi", $name, $phone, $email, $address, $birthday, $tags, $zip, $id);

            // Execute the query
            if ($stmt->execute()) {
                echo "Contact updated successfully!";
            } else {
                echo "Error executing query: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the query: " . $conn->error;
        }
    } else {
        echo "Missing required fields.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
