<?php
// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$stmt = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        die("Username or password not provided.");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("Username or password cannot be empty.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if username already exists
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo "Username already exists. Please choose another.";
        } else {
            // Insert new user
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: login.html");
                exit();
            } else {
                echo "Error storing data: " . $stmt->error;
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "Database error: " . $e->getMessage();
    } finally {
        // Clean up resources
        if ($stmt_check) {
            $stmt_check->close();
        }
        if ($stmt) {
            $stmt->close();
        }
    }
}

$conn->close();
?>
