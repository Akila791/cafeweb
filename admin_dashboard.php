<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

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

// Handle add new member
if (isset($_POST['add_member'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    $stmt = $conn->prepare("INSERT INTO admin_login (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $new_username, $new_password);
    if ($stmt->execute()) {
        echo "New member added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}


// Handle add new food item
if (isset($_POST['add_food'])) {
    $food_name = $_POST['food_name'];
    $food_description = $_POST['food_description'];
    $food_price = $_POST['food_price'];
    $cuisine_type = $_POST['cuisine_type'];
    
    $stmt = $conn->prepare("INSERT INTO menu (name, description, price, cuisine) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $food_name, $food_description, $food_price, $cuisine_type);
    if ($stmt->execute()) {
        echo "New food item added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Handle delete food item
if (isset($_POST['delete_food'])) {
    $food_id = $_POST['food_id'];

    $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param("i", $food_id);
    if ($stmt->execute()) {
        echo "Food item deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    background: url(../image/background1.jpg)center/cover no-repeat;
    margin: 0;
    padding: 0;
}

header {
    background-color: #ccc ;
    color: #333;
    padding: 10px 0;
    text-align: center;
}

header h1 {
    margin: 0;
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 15px;
}

nav ul li a {
    color: blue;
    text-decoration: none;
}

nav ul li a:hover {
    text-decoration: underline;
}

main {
    padding: 20px;
}

section {
    background: url(../image/background3.jpg)center/cover no-repeat;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
    padding: 20px;
}

section h2 {
    margin-top: 0;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: blue;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: red;
}

footer {
    text-align: center;
    background-color: #333;
    color: #fff;
    padding: 10px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
}

    </style>
</head>
<body>
    <header>
        <h1>Welcome, Admin</h1>
        <nav>
            <ul>
                <li><a href="../login.html">Dashboard</a></li>
                <li><a href="../login.html">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Add New Member</h2>
            <form method="POST" action="">
                <label for="new_username">Username:</label>
                <input type="text" id="new_username" name="new_username" required>
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit" name="add_member">Add Member</button>
            </form>
        </section>

        <section>
        <h2>Add New Food Item</h2>
        <form action="add_food.php" method="post" enctype="multipart/form-data">
            <label for="food_name">Food Name:</label>
            <input type="text" id="food_name" name="food_name" required>
            
            <label for="food_description">Description:</label>
            <textarea id="food_description" name="food_description" required></textarea>
            
            <label for="food_price">Price:</label>
            <input type="text" id="food_price" name="food_price" required>
            
            <label for="cuisine_type">Cuisine Type:</label>
            <select id="cuisine_type" name="cuisine_type" required>
                <option value="Sri Lankan">Sri Lankan</option>
                <option value="Chinese">Chinese</option>
                <option value="Italian">Italian</option>
            </select>
            
            <label for="food_image">Image:</label>
            <input type="file" id="food_image" name="food_image" accept="image/*" required>
            
            <button type="submit" name="add_food">Add Food Item</button>
         </form>
        </section>
              
            </form>
        </section>

        <section>
            <h2>Delete Food Item</h2>
            <form method="POST" action="">
                <label for="food_id">Food ID:</label>
                <input type="number" id="food_id" name="food_id" required>
                <button type="submit" name="delete_food">Delete Food</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
