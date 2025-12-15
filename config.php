<?php
// config.php - Central configuration file for Railway MySQL database connection

// --- Database Credentials (Using Railway Environment Variables) ---
define('DB_SERVER', '{{RAILWAY_PRIVATE_DOMAIN}}'); // Use the internal host variable
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'TzoChNMWXUjSYoqfnhgZxXhNPzSLjmVy'); // The actual root password provided
define('DB_NAME', 'railway'); // The database name

// --- Attempt to connect to MySQL database ---
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn === false) {
    // Log the error (and hide the details from the public)
    error_log("Database Connection Error: " . mysqli_connect_error());
    die("ERROR: The system is currently undergoing maintenance. Please try again shortly.");
}

// Set the charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Note: The variable $conn is now globally available when this file is included.
?>
