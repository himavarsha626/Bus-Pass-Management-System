<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'bus_pass';
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password is empty

// Create a new PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Check if bus_pass_id is provided
if (isset($_POST['bus_pass_id'])) {
    $bus_pass_id = $_POST['bus_pass_id'];

    // Debugging: Log the bus_pass_id received
    file_put_contents('php://stderr', "Received bus_pass_id: $bus_pass_id\n");

    // Prepare and execute the query to fetch bus pass details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE bus_pass_id = :bus_pass_id");
    $stmt->bindParam(':bus_pass_id', $bus_pass_id, PDO::PARAM_STR); // Use PDO::PARAM_STR for strings
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the result or error message
    if ($result) {
        echo json_encode([
            'success' => true,
            'bus_pass_id' => $result['bus_pass_id'],
            'name' => $result['name'],
            'route' => $result['route'],
            'expiry_date' => $result['expiry_date']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No bus pass found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Bus pass ID not provided']);
}
?>

