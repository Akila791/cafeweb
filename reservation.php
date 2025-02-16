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
  $date = $conn->real_escape_string($_POST['date']);
  $time = $conn->real_escape_string($_POST['time']);
  $guests = $conn->real_escape_string($_POST['guests']);
  $requests = $conn->real_escape_string($_POST['requests']);

  // Step 3: Insert data into your table (assuming 'reservations' table exists)
  $sql = "INSERT INTO reservations (name, email, date, time, guests, requests)
          VALUES ('$name', '$email', '$date', '$time', '$guests', '$requests')";

  if ($conn->query($sql) === TRUE) {
    echo "Reservation successfully made!. <a href='../reservation.html'>BACK</a>.";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close connection
$conn->close();
?>
