<?php
$servername = "localhost";
$username = "root"; // Default MySQL username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "bus_pass"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the frontend (JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Extract the pass type, user ID, and expiry date from the request
$userId = $data['userId']; // User ID to identify which record to update
$expiryDate = $data['expiryDate']; // The calculated expiry date
$passType = $data['passType']; // Pass type (monthly, quarterly, yearly)

// SQL to update only the expiry date
$sql = "UPDATE users SET expiry_date = '$expiryDate' WHERE user_id = '$userId'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Expiry date updated successfully!"]);
} else {
    echo json_encode(["message" => "Error: " . $conn->error]);
}

$conn->close();
?>
