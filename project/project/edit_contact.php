<?php
include('db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'], $data['name'], $data['phone'], $data['email'], $data['address'], $data['birthday'], $data['tags'], $data['zip'])) {
        $id = $data['id'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $address = $data['address'];
        $birthday = $data['birthday'];
        $tags = $data['tags'];
        $zip = $data['zip'];

        // Prepare the update query
        $query = "UPDATE contacts SET name = ?, phone = ?, email = ?, address = ?, birthday = ?, tags = ?, zip_code = ? WHERE id = ?";

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sssssssi", $name, $phone, $email, $address, $birthday, $tags, $zip, $id);
            if ($stmt->execute()) {
                echo "Contact updated successfully!";
            } else {
                echo "Error executing query: " . $stmt->error;
            }
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

$conn->close();
?>
