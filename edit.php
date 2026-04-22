<?php
require_once 'classes/Student.php';

$message = '';
$messageType = '';

// Check if ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$student = new Student();
$student->id = $_GET['id'];

// Fetch existing data
if(!$student->readOne()) {
    header('Location: index.php?msg=error');
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    
    // Check if email already exists (excluding current student)
    if(empty($errors) && $student->emailExists($student->id)) {
        $errors[] = "Email already exists. Please use a different email.";
    }
    
    if(empty($errors)) {
        if($student->update()) {
            header('Location: index.php?msg=updated');
            exit;
        } else {
            $message = "Failed to update student. Please try again.";
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
    <h2>Edit Student</h2>
    
    <?php if($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $student->id); ?>">
        <div class="form-group">
            <label for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" 
                   value="<?php echo htmlspecialchars($student->first_name); ?>"
                   required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" 
                   value="<?php echo htmlspecialchars($student->last_name); ?>"
                   required>
        </div>
        <div class="form-group">
            <label for="registration_number">Registration Number *</label>
            <input type="text" id="registration_number" name="registration_number" 
                   placeholder="e.g., 20/X/0000/PS"
                   pattern="\d{2}/[A-Z]{1}/\d{5}/[A-Z]{2}"
                   value="<?php echo htmlspecialchars($student->registration_number); ?>"
                   required>
            <small>Format: YY/Letter/5Digits/2Letters (e.g., 20/X/0000/PS)</small>
        </div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($student->email); ?>"
                   required>
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" 
                   placeholder="10-digit number"
                   pattern="\d{10}"
                   maxlength="10"
                   value="<?php echo htmlspecialchars($student->phone); ?>">
            <small>Must be exactly 10 digits</small>
        </div>
        
        <div class="form-group">
            <label for="course">Course *</label>
            <select id="course" name="course" required>
                <option value="">Select a course</option>
                <?php
                $courses = ['Computer Science', 'Information Technology', 'Software Engineering', 'Data Science', 'Cybersecurity'];
                foreach($courses as $c) {
                    $selected = ($student->course == $c) ? 'selected' : '';
                    echo "<option value=\"$c\" $selected>$c</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="enrollment_date">Enrollment Date *</label>
            <input type="date" id="enrollment_date" name="enrollment_date" 
                   value="<?php echo htmlspecialchars($student->enrollment_date); ?>"
                   required>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Student</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php include_once 'includes/footer.php'; ?>