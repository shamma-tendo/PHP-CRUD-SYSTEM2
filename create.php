<?php
require_once 'classes/Student.php';

$message = '';
$messageType = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student = new Student();
    
    // Set properties
    $student->first_name = trim($_POST['first_name'] ?? '');
    $student->last_name = trim($_POST['last_name'] ?? '');
    $student->registration_number = trim($_POST['registration_number'] ?? '');
    $student->email = trim($_POST['email'] ?? '');
    $student->phone = trim($_POST['phone'] ?? '');
    $student->course = trim($_POST['course'] ?? '');
    $student->enrollment_date = trim($_POST['enrollment_date'] ?? '');
    
    // Validation
    $errors = [];
    
    if(empty($student->first_name)) $errors[] = "First name is required.";
    if(empty($student->last_name)) $errors[] = "Last name is required.";
    if(empty($student->registration_number)) $errors[] = "Registration number is required.";
    elseif(!$student->validateRegistrationNumber()) $errors[] = "Registration number format must be like 20/X/0000/PS (YY/Letter/5Digits/2Letters).";
    if(empty($student->email)) $errors[] = "Email is required.";
    if(!filter_var($student->email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if(!empty($student->phone) && !$student->validatePhone()) $errors[] = "Phone number must be exactly 10 digits.";
    if(empty($student->course)) $errors[] = "Course is required.";
    if(empty($student->enrollment_date)) $errors[] = "Enrollment date is required.";
    
    // Check if email already exists
    if(empty($errors) && $student->emailExists()) {
        $errors[] = "Email already exists. Please use a different email.";
    }
    
    if(empty($errors)) {
        if($student->create()) {
            // Redirect to prevent form resubmission
            header('Location: index.php?msg=created');
            exit;
        } else {
            $message = "Failed to create student. Please try again.";
            $messageType = 'error';
        }
    } else {
        $message = implode('<br>', $errors);
        $messageType = 'error';
    }
}

include_once 'includes/header.php';
?>

<div class="form-container">
    <h2>Add New Student</h2>
    
    <?php if($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" 
                   value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>"
                   required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" 
                   value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>"
                   required>
        </div>
        <div class="form-group">
            <label for="registration_number">Registration Number *</label>
            <input type="text" id="registration_number" name="registration_number" 
                   placeholder="e.g., 20/X/0000/PS"
                   pattern="\d{2}/[A-Z]{1}/\d{5}/[A-Z]{2}"
                   value="<?php echo isset($_POST['registration_number']) ? htmlspecialchars($_POST['registration_number']) : ''; ?>"
                   required>
            <small>Format: YY/Letter/5Digits/2Letters (e.g., 20/X/0000/PS)</small>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                   required>
            <small>Must be a valid email address</small>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" 
                   placeholder="10-digit number"
                   pattern="\d{10}"
                   maxlength="10"
                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            <small>Must be exactly 10 digits</small>
        </div>
        
        <div class="form-group">
            <label for="course">Course *</label>
            <select id="course" name="course" required>
                <option value="">Select a course</option>
                <option value="Computer Science" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                <option value="Information Technology" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                <option value="Software Engineering" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Software Engineering') ? 'selected' : ''; ?>>Software Engineering</option>
                <option value="Data Science" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Data Science') ? 'selected' : ''; ?>>Data Science</option>
                <option value="Cybersecurity" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Cybersecurity') ? 'selected' : ''; ?>>Cybersecurity</option>
                <option value="Machine Learning" <?php echo (isset($_POST['course']) && $_POST['course'] == 'Machine Learning') ? 'selected' : ''; ?>>Machine Learning</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="enrollment_date">Enrollment Date *</label>
            <input type="date" id="enrollment_date" name="enrollment_date" 
                   value="<?php echo isset($_POST['enrollment_date']) ? htmlspecialchars($_POST['enrollment_date']) : date('Y-m-d'); ?>"
                   required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Student</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>