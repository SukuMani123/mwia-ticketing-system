<?php
// File path: /path/to/your/script.php

// Step 1: Define database credentials
$servername = "localhost";
$username = "root";
$password = "ramesh123";
$dbname = "mwiaTicketingSystem";

// Step 2: Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Step 3: Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Perform database operations here

// Step 4: Close the connection
$conn->close();

