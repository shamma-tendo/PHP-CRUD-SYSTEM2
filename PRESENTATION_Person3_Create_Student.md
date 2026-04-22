# Person 3: Create Student Feature
**Duration: 5-7 minutes**

## Overview
- This is where users add new students to the system
- Located at create.php
- Form-based data entry

## User Interface
- Simple form with all required fields
- Clear validation messages
- Visual feedback for errors

## Form Fields Breakdown

### 1. First Name *
- Text input
- Required field
- No special formatting

### 2. Last Name *
- Text input
- Required field
- No special formatting

### 3. Registration Number *
- **Format**: YY/Letter/5Digits/2Letters
- **Example**: 20/X/0000/PS
- **Validation**: 
  - Client-side: HTML5 pattern matching
  - Server-side: validateRegistrationNumber() method
- Must be unique in database

### 4. Email *
- Email input type
- Required field
- Must be valid email format (user@domain.com)
- Must be unique in database
- Server-side validation using filter_var()

### 5. Phone (Optional)
- Tel input type
- **Format**: 10 digits only
- **Pattern**: 1234567890 (no hyphens or special characters)
- **Validation**: 
  - Maxlength: 10 characters
  - Pattern: \d{10}
  - Server-side: validatePhone() method

### 6. Course *
- Dropdown select
- Required field
- Options:
  - Computer Science
  - Information Technology
  - Software Engineering
  - Data Science
  - Cybersecurity
  - Machine Learning

### 7. Enrollment Date *
- Date input type
- Required field
- Default: Today's date
- Format: YYYY-MM-DD

## Validation Process

### Client-Side (Before Submission)
- HTML5 required attributes
- Pattern validation for registration_number and phone
- Email format check
- Date picker validation

### Server-Side (After Submission)
```php
$errors = [];
- Check all required fields are filled
- validateRegistrationNumber() - specific format
- validatePhone() - exactly 10 digits
- filter_var() - email format
- emailExists() - no duplicates
```

## Error Handling
- If validation fails:
  - All errors displayed to user
  - Form data retained (except sensitive data)
  - No database insert
- Success:
  - Redirect to index.php with success message
  - "Student added successfully!"

## Security Measures
- htmlspecialchars() - prevents XSS attacks
- strip_tags() - removes any HTML tags
- Prepared statements - prevents SQL injection
- Type validation - ensures correct data types

## Demo Steps
1. Show empty form
2. Try submitting without data - show "required" errors
3. Enter invalid registration number - show format error
4. Enter invalid phone (11 digits) - show "exactly 10 digits" error
5. Enter valid data with valid registration number and phone
6. Show success message on redirect
7. Show new student in the list

## Example Valid Data
- First Name: John
- Last Name: Doe
- Registration Number: 23/U/12345/CS
- Email: john.doe@university.edu
- Phone: 9876543210
- Course: Computer Science
- Enrollment Date: 2026-04-22

## Transition
"Now that we've seen how to add students, Person 4 will show you how to view all students, edit them, and delete them..."
