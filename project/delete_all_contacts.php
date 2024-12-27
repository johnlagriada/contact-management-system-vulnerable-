<?php
include('db.php');
$query = "DELETE FROM contacts";
mysqli_query($conn, $query);
echo 'All contacts deleted';
?>