<?php
// config.php

// 1. Try to get values from Vercel Environment Variables first
// 2. If they don't exist (e.g., running locally), use the Clever Cloud fallbacks
$host = getenv('MYSQL_ADDON_HOST') ?: 'b2zxfupothfelgs6h1xv-mysql.services.clever-cloud.com';
$db   = getenv('MYSQL_ADDON_DB') ?: 'b2zxfupothfelgs6h1xv';
$user = getenv('MYSQL_ADDON_USER') ?: 'ugr7l8g8w4vnakgx';
$pass = getenv('MYSQL_ADDON_PASSWORD') ?: 'TjC3vOzGDdybHtx1Eup';
$port = getenv('MYSQL_ADDON_PORT') ?: '3306';

try {
    // Set up the Data Source Name (DSN)
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    
    // Create the PDO connection
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    
} catch (PDOException $e) {
    // If the connection fails, stop the script and show an error.
    // (In a real production environment, you would log this instead of showing it).
    error_log("Database Connection Failed: " . $e->getMessage());
    die("Database connection failed. Please check the server logs for details.");
}
?>
