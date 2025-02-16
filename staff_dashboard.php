<?php
session_start();
if (!isset($_SESSION['staff_username'])) {
    header("Location: staff_login.php");
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

// Fetch orders
$order_query = "SELECT * FROM orders";
$order_result = $conn->query($order_query);

// Fetch reservations
$reservation_query = "SELECT * FROM reservations";
$reservation_result = $conn->query($reservation_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];
        $delete_order_query = "DELETE FROM orders WHERE id = ?";
        $stmt = $conn->prepare($delete_order_query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        header("Location: staff_dashboard.php");
        exit();
    } elseif (isset($_POST['delete_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $delete_reservation_query = "DELETE FROM reservations WHERE id = ?";
        $stmt = $conn->prepare($delete_reservation_query);
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $stmt->close();
        header("Location: staff_dashboard.php");
        exit();
    } elseif (isset($_POST['edit_order'])) {
        $order_id = $_POST['order_id'];
        $order_items = $_POST['order_items']; // Updated to reflect the actual column
        $update_order_query = "UPDATE orders SET items = ? WHERE id = ?";
        $stmt = $conn->prepare($update_order_query);
        $stmt->bind_param("si", $order_items, $order_id);
        $stmt->execute();
        $stmt->close();
        header("Location: staff_dashboard.php");
        exit();
    } elseif (isset($_POST['edit_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $reservation_name = $_POST['reservation_name']; // Update as necessary
        $update_reservation_query = "UPDATE reservations SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($update_reservation_query);
        $stmt->bind_param("si", $reservation_name, $reservation_id);
        $stmt->execute();
        $stmt->close();
        header("Location: staff_dashboard.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
   
    <style>
/* styles.css */

body {
    font-family: Arial, sans-serif;
    background-color: #ffffff;
    background: url(../image/background1.jpg)center/cover no-repeat;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
    background: url(../image/background3.jpg)center/cover no-repeat;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1, h2 {
    color: #333;
    text-align: center;
}

nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

nav ul li {
    margin: 0 10px;
}

nav ul li a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

nav ul li a:hover {
    color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f2f2f2;
    color: #333;
}

form {
    display: inline-block;
    margin: 0 5px;
}

form input[type="text"] {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-right: 10px;
}

form button {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

form button:hover {
    background-color: #0056b3;
}

@media (max-width: 600px) {
    .dashboard-container {
        padding: 10px;
    }

    nav ul {
        flex-direction: column;
        align-items: center;
    }

    nav ul li {
        margin: 5px 0;
    }

    form {
        display: block;
        margin-bottom: 10px;
    }

    form input[type="text"] {
        width: 100%;
        margin-bottom: 10px;
    }

    table th, table td {
        font-size: 14px;
    }
}

 
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['staff_username']); ?>!</h1>
        <nav>
            <ul>
            <li><a href="../login.html">Dashboard</a></li>
            <li><a href="../login.html">Logout</a></li>
            </ul>
        </nav>

        <h2>Orders</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Items</th> <!-- Updated to match your schema -->
                <th>Actions</th>
            </tr>
            <?php while ($row = $order_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['items']); ?></td>
                <td>
                    <form action="staff_dashboard.php" method="post">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="text" name="order_items" value="<?php echo htmlspecialchars($row['items']); ?>"> <!-- Updated -->
                        <button type="submit" name="edit_order">Edit</button>
                        <button type="submit" name="delete_order">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Reservations</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th> <!-- Updated to match your schema -->
                <th>Actions</th>
            </tr>
            <?php while ($row = $reservation_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td> <!-- Updated -->
                <td>
                    <form action="staff_dashboard.php" method="post">
                        <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                        <input type="text" name="reservation_name" value="<?php echo htmlspecialchars($row['name']); ?>"> <!-- Updated -->
                        <button type="submit" name="edit_reservation">Edit</button>
                        <button type="submit" name="delete_reservation">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>

