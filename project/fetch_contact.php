<?php
// Include the database connection
include('db.php');

// Fetch all contacts
$result = $conn->query("SELECT * FROM contacts");

// Check if there are any contacts
if ($result->num_rows > 0) {
    $contacts = [];
    while ($row = $result->fetch_assoc()) {
        $contacts[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'address' => $row['address'],
            'birthday' => $row['birthday'],
            'tags' => $row['tags'],
            'zip' => $row['zip_code']  // Make sure this is the correct column name for the zip code
        ];
    }
    echo json_encode($contacts);
} else {
    echo json_encode([]); // Return an empty array if no contacts
}

$conn->close();
?>
