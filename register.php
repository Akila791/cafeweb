<?php
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
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database using prepared statements
$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful. <a href='../login.html'>Login here</a>.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
