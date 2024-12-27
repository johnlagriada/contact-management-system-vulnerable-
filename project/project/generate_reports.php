<?php
// Include the database connection
include('db.php');

// Fetch all contacts
$result = $conn->query("SELECT * FROM contacts");

if ($result->num_rows > 0) {
    // Set the header for the CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contact_report.csv"');
    
    // Open the output stream for the CSV file
    $output = fopen('php://output', 'w');
    
    // Write the column headings for the CSV file
    fputcsv($output, ['ID', 'Name', 'Phone', 'Email', 'Address', 'Birthday', 'Tags', 'Zip Code']);
    
    // Write the data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['name'],
            $row['phone'],
            $row['email'],
            $row['address'],
            $row['birthday'],
            $row['tags'],
            $row['zip_code'] // Make sure to match the correct column name for zip code
        ]);
    }
    
    // Close the output stream
    fclose($output);
} else {
    echo "No contacts found.";
}

$conn->close();
?>
