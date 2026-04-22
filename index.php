<?php

require_once 'classes/Student.php';
include_once 'includes/header.php';

$student = new Student();
$result = $student->read();
?>

<h2>Student List</h2>

<?php if(isset($_GET['msg'])): ?>
    <?php if($_GET['msg'] == 'created'): ?>
        <div class="message success">Student added successfully!</div>
    <?php elseif($_GET['msg'] == 'updated'): ?>
        <div class="message success">Student updated successfully!</div>
    <?php elseif($_GET['msg'] == 'deleted'): ?>
        <div class="message success">Student deleted successfully!</div>
    <?php elseif($_GET['msg'] == 'error'): ?>
        <div class="message error">An error occurred. Please try again.</div>
    <?php endif; ?>
<?php endif; ?>

<div class="table-container">
    <?php if($result->rowCount() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No.</th> <!-- Changed from ID to No. for sequential numbering -->
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Enrollment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; // Initialize counter ?>
                <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $counter++; // Display sequential number instead of $row['id'] ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td><?php echo htmlspecialchars($row['enrollment_date']); ?></td>
                    <td>
                        <div class="actions">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-records">
            <p>No students found. <a href="create.php">Add a new student</a>.</p>
        </div>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>