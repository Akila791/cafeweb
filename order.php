<?php
// Step 1: Establish connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Step 2: Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Escape user inputs for security
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $phone = $conn->real_escape_string($_POST['phone']);
  $items = implode(", ", $_POST['items']); // Convert array to comma-separated string
  $quantity = $conn->real_escape_string($_POST['quantity']);
  $requests = $conn->real_escape_string($_POST['requests']);

  // Step 3: Insert data into your table (assuming 'orders' table exists)
  $sql = "INSERT INTO orders (name, email, phone, items, quantity, requests)
          VALUES ('$name', '$email', '$phone', '$items', '$quantity', '$requests')";

  if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!. <a href='../order.html'>BACK</a>.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close connection
$conn->close();
?>
