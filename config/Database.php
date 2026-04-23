<?php
// config/Database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'student_management';
    private $username = 'root';
    private $password = ''; // Update with your password
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
        return $this->conn;
    }
    public function cleanTable($table = 'students') {
        $conn = $this->getConnection();
        try {
            $conn->exec("TRUNCATE TABLE $table"); // Clears all data and resets auto-increment
            return true;
        } catch(PDOException $e) {
            die("Clean failed: " . $e->getMessage());
        }
    }
}
?>