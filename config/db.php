<?php
$host = 'localhost';
$db   = 'urban_furniture_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}


// $host = 'sql101.infinityfree.com';
// $db   = 'if0_38744358_ueban_furnitures_db';
// $user = 'if0_38744358';
// $pass = 'IRDkjUuxLL';

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("DB Connection failed: " . $e->getMessage());
// }



// // connection for infinityfree online hosting service
// // uncomment when hosting
// $host = 'sql101.infinityfree.com';
// $db   = 'if0_38744358_ueban_furnitures_db';
// $user = 'if0_38744358';
// $pass = 'IRDkjUuxLL';
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ];

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (\PDOException $e) {
//     die("DB connection failed: " . $e->getMessage());
// }

?>
