<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'crud');

 $host = "localhost";
 $user = "root";
 $password = "test";
 $database = "labtest";

/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $database, $user, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>
