<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "bus_pass");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$busPassID = $data['busPassID'];

$query = $conn->prepare("SELECT * FROM users WHERE bus_pass_id = ?");
$query->bind_param("s", $busPassID);
$query->execute();

$result = $query->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "name" => $row['name'],
        "age" => $row['age'],
        "aadhar" => $row['aadhar'],
        "institution" => $row['institution'],
        "course" => $row['course'],
        "route" => $row['route']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No details found"]);
}

$conn->close();
?>
