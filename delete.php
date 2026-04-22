<?php
require_once 'classes/Student.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $student = new Student();
    $student->id = $_GET['id'];
    
    if($student->delete()) {
        header('Location: index.php?msg=deleted');
    } else {
        header('Location: index.php?msg=error');
    }
} else {
    header('Location: index.php');
}
exit;
?>