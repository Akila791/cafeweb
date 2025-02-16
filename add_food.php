<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['add_food'])) {
    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_price = $_POST['food_price'];
    $cuisine_type = $_POST['cuisine_type'];

    // Handle file upload
    $image = $_FILES['food_image']['name'];
    $image_tmp = $_FILES['food_image']['tmp_name'];
    $uploads_dir = '../uploads/';

    // Ensure the uploads directory exists
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $image_path = $uploads_dir . basename($image);

    // Move the uploaded file to the 'uploads' directory
    if (move_uploaded_file($image_tmp, $image_path)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO menu (name, description, price, cuisine, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $food_name, $food_description, $food_price, $cuisine_type, $image_path);
        if ($stmt->execute()) {
            echo "New food item added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>
