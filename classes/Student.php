<?php
// classes/Student.php

require_once __DIR__ . '/../config/Database.php';

class Student {
    private $conn;
    private $table = 'students';
    
    // Properties
    public $id;
    public $first_name;
    public $last_name;
    public $registration_number;
    public $email;
    public $phone;
    public $course;
    public $enrollment_date;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    // Create Student
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (first_name, last_name,registration_number, email, phone, course, enrollment_date)
                  VALUES
                  (:first_name, :last_name, :registration_number, :email, :phone, :course, :enrollment_date)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->registration_number = htmlspecialchars(strip_tags($this->registration_number));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->course = htmlspecialchars(strip_tags($this->course));
        
        // Bind parameters
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':registration_number', $this->registration_number);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':course', $this->course);
        $stmt->bindParam(':enrollment_date', $this->enrollment_date);
        
        return $stmt->execute();
    }
    
    // Read all students
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Read single student
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->registration_number = $row['registration_number'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->course = $row['course'];
            $this->enrollment_date = $row['enrollment_date'];
            return true;
        }
        return false;
    }
    
    // Update student
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET first_name = :first_name,
                      last_name = :last_name,
                      registration_number = :registration_number,
                      email = :email,
                      phone = :phone,
                      course = :course,
                      enrollment_date = :enrollment_date
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize inputs
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->registration_number = htmlspecialchars(strip_tags($this->registration_number));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->course = htmlspecialchars(strip_tags($this->course));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameters
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':registration_number', $this->registration_number);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':course', $this->course);
        $stmt->bindParam(':enrollment_date', $this->enrollment_date);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Delete student
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Check if email exists (except for current record when updating)
    public function emailExists($exclude_id = null) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        
        if($exclude_id) {
            $query .= " AND id != :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':email', $this->email);
        
        if($exclude_id) {
            $stmt->bindParam(':id', $exclude_id, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    // Validate registration number format (24/U/07480/PS)
    public function validateRegistrationNumber() {
        $pattern = '/^\d{2}\/[A-Z]{1}\/\d{5}\/[A-Z]{2}$/';
        return preg_match($pattern, $this->registration_number) === 1;
    }
    
    // Validate phone number (exactly 10 digits)
    public function validatePhone() {
        $pattern = '/^\d{10}$/';
        return preg_match($pattern, $this->phone) === 1;
    }
    
    public function clean() {
        $db = new Database();
        return $db->cleanTable($this->table);
    }

}
?>