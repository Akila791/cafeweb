<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - The Gallery Café</title>
    <link rel="stylesheet" href="style.css">

    <style>

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background: url(../image/background1.jpg)center/cover no-repeat;
}

header nav {
    background: url(../image/background4.jpg) center/cover no-repeat;
    display: flex;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
    position: relative;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    width: 100%;
    box-sizing: border-box;
}

header nav ul li {
    display: inline-block;
    margin-right: 20px;
}

header nav ul li a {
    font-family: 'Georgia', serif;
    font-size: 1rem; 
    font-weight: bold; 
    color: #000000; 
    text-decoration: none; 
    padding: 10px 15px;
    border-radius: 10px; 
    transition: all 0.3s ease;
}

header nav ul li a:hover {
    background-color: #2173b688;
    box-shadow: 0 8px 16px rgb(0, 0, 0);
}

header .logo img {
    width: 80px;
    height: auto;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 5px;
    background-color: #fff;
}

header .logo img:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 16px rgb(0, 0, 0);
}

main {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background: url(../image/background4.jpg)center/cover no-repeat;
    
    
}

h1 {
    font-size: 32px;
    margin-bottom: 20px;
    text-align: center;
    color: #444;
}

#search {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.menu-card {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.filter-button {
    background-color: #2173b6;
    color: #fff;
    border: none;
    padding: 10px 20px;
    margin: 0 10px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.filter-button:hover {
    background-color: #1a5f8a;
}

.menu-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    box-shadow: 0 4px 5px rgba(0, 0, 0, 0.1);
    position: relative; /* Add position relative for the button positioning */
}

.menu-details {
    flex: 1; /* Take up remaining space */
}


.menu-item img {
    border-radius: 8px;
    margin-right: 15px;
    max-width: 300px; 
    height: auto;
    object-fit: cover; 
}

.menu-item h3 {
    font-size: 28px; 
    color: #1a5f8a;
    font-weight: bold;
    transition: transform 0.3s ease;
    margin: 0; 
    text-align: center;
}

.menu-item h3:hover {
    transform: scale(1.02);
 
}

.menu-item p {
    margin: 5px ;  
    
}

.menu-item p:hover {
    transform: scale(1.0); 
    
}

.order-now-button {
    display: inline-block;
    background-color: #2173b6;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.3s ease;
    position: absolute; /* Position button at the bottom-right corner */
    bottom: 15px;
    right: 15px;
}

.order-now-button:hover {
    background-color: #1a5f8a;
    transform: scale(1.05); /* Slightly enlarge on hover */
}



    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../image/logo.jpg" alt="Gallery Cafe Logo">
            </div>
            <ul>
           
                <li><a href="../index.html">Homes</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="../order.html">Order</a></li>
                <li><a href="../about.html">About</a></li>
                <li><a href="../reservation.html">Reservation</a></li>
                <li><a href="../parking.html">parking </a></li>
                <li><a href="../promotion.html">Promotion</a></li>
                <li><a href="../login.html">Login</a></li>
                
            </ul>
        </nav>
    </header>

    <main>
        <section id="menu">
            <h1>Our Menu</h1>
            <input type="text" id="search" placeholder="Search for dishes...">

            <div class="menu-card">
    <button class="filter-button" data-filter="all">All</button>
    <button class="filter-button" data-filter="Sri Lankan">Sri Lankan</button>
    <button class="filter-button" data-filter="Italian">Italian</button>
    <button class="filter-button" data-filter="Chinese">Chinese</button>
</div>

            <div id="menu-items">
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

                // Fetch menu items
                $sql = "SELECT * FROM menu";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()):
                ?>
                <div class="menu-item" data-cuisine="<?php echo htmlspecialchars($row['cuisine']); ?>">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <div class="menu-details">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p><strong>Price:</strong> <?php echo htmlspecialchars($row['price']); ?></p>
                        <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($row['cuisine']); ?></p>
                        <a href="../order.html" class="order-now-button">Order Now</a>
                    </div>
                </div>

                <?php endwhile; ?>
                <?php $conn->close(); ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search');
        const filterButtons = document.querySelectorAll('.filter-button');
        const menuItems = document.querySelectorAll('.menu-item');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            menuItems.forEach(item => {
                const name = item.querySelector('h3').textContent.toLowerCase();
                const description = item.querySelector('p').textContent.toLowerCase();
                item.style.display = name.includes(searchTerm) || description.includes(searchTerm) ? 'block' : 'none';
            });
        });

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                menuItems.forEach(item => {
                    const cuisine = item.getAttribute('data-cuisine');
                    item.style.display = filter === 'all' || cuisine === filter ? 'block' : 'none';
                });
            });
        });
    });
    </script>
</body>
</html>
