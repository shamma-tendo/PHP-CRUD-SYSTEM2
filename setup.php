<?php
// setup.php - Run this file once to create the database and table

$host = 'localhost';
$username = 'root';
$password = ''; // Your MySQL password

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS student_management";
    $pdo->exec($sql);
    echo "Database created successfully<br>";
    
    // Select the database
    $pdo->exec("USE student_management");
    
    // Drop existing table if it exists
    $pdo->exec("DROP TABLE IF EXISTS students");
    
    // Create students table
    $sql = "CREATE TABLE students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        registration_number VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(20),
        course VARCHAR(100),
        enrollment_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table 'students' created successfully with registration_number column<br>";
    echo "<strong>Setup complete!</strong> You can now <a href='index.php'>view the application</a>.";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>