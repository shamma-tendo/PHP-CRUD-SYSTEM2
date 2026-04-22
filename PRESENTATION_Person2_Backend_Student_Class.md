# Person 2: Backend Architecture & Student Class
**Duration: 5-7 minutes**

## Object-Oriented Programming in PHP
- Student.php uses class-based approach
- Encapsulation: private properties and public methods
- Clean, reusable code structure

## Student Class Properties
```php
private $conn;           // Database connection
private $table = 'students';  // Table name

// Public Properties
public $id, $first_name, $last_name, $registration_number;
public $email, $phone, $course, $enrollment_date;
```

## CRUD Operations

### 1. CREATE - Add New Student
**Method**: `create()`
- Accepts student properties
- Sanitizes input using htmlspecialchars() and strip_tags()
- Binds parameters safely (prevents SQL injection)
- Returns true/false for success

### 2. READ - Get All Students
**Method**: `read()`
- Fetches all students from database
- Orders by created_at DESC (newest first)
- Returns statement object for iteration

### 3. READ - Get Single Student
**Method**: `readOne()`
- Fetches specific student by ID
- Populates all class properties
- Used when editing a student

### 4. UPDATE - Modify Student
**Method**: `update()`
- Updates all student information
- Sanitizes all inputs
- Binds parameters safely
- Where clause: id = :id

### 5. DELETE - Remove Student
**Method**: `delete()`
- Deletes student by ID
- Simple query with WHERE condition

## Validation Methods

### `validateRegistrationNumber()`
- Pattern: `\d{2}/[A-Z]{1}/\d{5}/[A-Z]{2}`
- Example: 20/X/0000/PS
- Returns true if matches format

### `validatePhone()`
- Pattern: `\d{10}`
- Must be exactly 10 digits
- Returns true if valid

### `emailExists($exclude_id = null)`
- Checks if email already exists in database
- Can exclude current record when updating
- Prevents duplicate emails

## Key Security Features
- **Prepared Statements**: Prevents SQL injection
- **Input Sanitization**: htmlspecialchars() and strip_tags()
- **Type Hints**: PDO::PARAM_INT for database calls
- **Validation**: Format and uniqueness checks

## Database Connection
- Handled by Database class
- PDO (PHP Data Objects) used
- Error mode set to exceptions
- Default fetch mode: associative array

## Code Example Flow
```
1. Create Student object
2. Set properties (first_name, last_name, etc.)
3. Call validation methods
4. Call appropriate CRUD method
5. Check return value for success/failure
```

## Transition
"Now that you understand how the backend works, Person 3 will show you how users interact with the Create Student feature..."
