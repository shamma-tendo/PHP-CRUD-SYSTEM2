# Person 4: View, Edit & Delete Features
**Duration: 5-7 minutes**

## Overview
- Display all students (index.php)
- Edit student information (edit.php)
- Delete students with confirmation

## VIEW ALL STUDENTS (index.php)

### What Gets Displayed
- Table with all students
- Columns shown:
  - No. (Sequential numbering, not ID)
  - Name (First Name + Last Name)
  - Registration Number
  - Email
  - Phone
  - Course
  - Enrollment Date
  - Actions (Edit, Delete buttons)

### Table Features
- Students listed newest first (ORDER BY created_at DESC)
- Sequential numbering (counter starts at 1)
- Sorted by creation date

### No Students Message
- If database is empty: "No students found. Add a new student"
- Link directly to create.php

### Success Messages
After actions, users see:
- "Student added successfully!" - After create
- "Student updated successfully!" - After edit
- "Student deleted successfully!" - After delete

## EDIT STUDENT (edit.php)

### How to Access
- Click "Edit" button on any student row in the table
- URL passes student ID: `edit.php?id=123`

### Pre-filled Form
- All student information pre-loaded
- Users can modify any field
- Same validation rules as create

### Editable Fields
1. **First Name** - Can change
2. **Last Name** - Can change
3. **Registration Number** - Can change (must maintain format)
4. **Email** - Can change (must be unique, excluding current record)
5. **Phone** - Can change (must be 10 digits)
6. **Course** - Can change
7. **Enrollment Date** - Can change

### Validation on Edit
- Same as create, but with exception:
  - Email uniqueness check excludes current student
  - Allows keeping same email

### Form Actions
- **Update Button**: Saves changes to database
- **Cancel Button**: Returns to index.php without changes

### Security
- Check if student ID exists
- Validate all inputs before update
- Prepared statements prevent SQL injection

## DELETE STUDENT (delete.php)

### Delete Process
1. Click "Delete" button on student row
2. JavaScript confirmation: "Are you sure you want to delete this student?"
3. User confirms or cancels
4. If confirmed: student removed from database
5. Redirect to index.php with success message

### How It Works
```
1. Get student ID from URL parameter
2. Execute DELETE query with student ID
3. Redirect back to list
4. Show "Student deleted successfully!" message
```

### Safety Features
- Confirmation dialog prevents accidental deletion
- Simple and straightforward process
- One-click delete (after confirmation)

## Demo Steps

### View All
1. Show the main student list table
2. Point out each column
3. Explain sequential numbering
4. Show success messages from previous actions

### Edit Example
1. Click "Edit" on a student
2. Show pre-filled form with current data
3. Modify some fields (e.g., phone, course)
4. Show validation if entering invalid data
5. Submit and show success message
6. Return to list and verify changes

### Delete Example
1. Click "Delete" on a different student
2. Show confirmation dialog
3. Confirm deletion
4. Show success message
5. Verify student removed from table

## Database Changes Reflected
- Updates happen instantly
- Changes persist in database
- All operations saved permanently

## SQL Queries Used

### Read All
```sql
SELECT * FROM students ORDER BY created_at DESC
```

### Read Single (for edit)
```sql
SELECT * FROM students WHERE id = :id LIMIT 1
```

### Update
```sql
UPDATE students SET first_name = :first_name, ... WHERE id = :id
```

### Delete
```sql
DELETE FROM students WHERE id = :id
```

## Transition
"Now that we've covered all the functionality, Person 5 will discuss the user interface, styling, and overall project summary..."
