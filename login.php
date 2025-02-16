<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user exists
$sql = "SELECT id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct
        $_SESSION['user_id'] = $id;

        // Redirect to customer dashboard
        header("Location: ../order.html");
        exit();
    } else {
        // Invalid password
        echo "Invalid email or password.";
    }
} else {
    // No user found
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>
