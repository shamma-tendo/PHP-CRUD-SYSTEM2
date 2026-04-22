# Person 1: Project Overview & Database
**Duration: 5-7 minutes**

## Introduction
- Welcome everyone to our Student Management System project
- This is a PHP-based web application for managing student records
- Built with PHP, MySQL, and HTML/CSS

## What is the Student Management System?
- A centralized platform to store and manage student information
- Allows users to Create, Read, Update, and Delete student records
- Validates input data to ensure data quality
- Unique registration numbers and email addresses for each student

## Technology Stack
- **Backend**: PHP (Object-Oriented)
- **Database**: MySQL
- **Frontend**: HTML5, CSS3
- **Architecture**: MVC-like structure with classes and includes

## Project Structure
```
student-management/
├── classes/Student.php (Student class with CRUD operations)
├── config/Database.php (Database connection)
├── includes/ (header.php, footer.php)
├── css/style.css (Styling)
├── create.php, edit.php, delete.php, index.php (Pages)
└── setup.php (Database initialization)
```

## Database Setup
- **Show**: Navigate to setup.php
- Explain what happens:
  - Creates database: `student_management`
  - Creates table: `students`
  - Drops old table if exists (ensures clean state)

## Database Schema
Table: `students`
- `id` - Auto-increment primary key
- `first_name` - Student first name
- `last_name` - Student last name
- `registration_number` - Unique registration (Format: YY/Letter/5Digits/2Letters)
- `email` - Unique email address
- `phone` - 10-digit phone number
- `course` - Course name
- `enrollment_date` - Date of enrollment
- `created_at` - Timestamp

## Key Features to Highlight
1. Data Validation
2. Unique constraints (email, registration number)
3. Phone format: 10 digits only
4. Registration number format: YY/Letter/5Digits/2Letters

## Transition
"Now that we understand the database structure, let me pass it to Person 2 who will explain how the Student class works and handles all these operations..."
