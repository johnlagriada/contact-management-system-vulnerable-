<?php
include('db.php');
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

$query = "DELETE FROM contacts WHERE id='$id'";
mysqli_query($conn, $query);
echo 'Contact deleted';
?>
