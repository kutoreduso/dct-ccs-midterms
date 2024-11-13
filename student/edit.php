<?php
session_start();
$pageTitle = "Edit Student";
include '../header.php';
include '../function.php';
guard();

$errors = [];
$studentToEdit = null;
$studentIndex = null;

if(isset($_REQUEST['student_id'])) {
    $student_id = $_REQUEST['student_id'];

        foreach($_SESSION['student_data'] as $key => $student) {
            if ($student['student_id'] === $student_id) {
                $studentToEdit = $student;
                $studentIndex = $key;
                break;
        }
    }
}


?>
<div class="card p-3 container mt-5">
    <h2>Edit Student</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
        </ol>
    </nav>


        <form action="edit.php?student_id=<?= urlencode($studentToEdit['student_id']) ?>" method="post">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($studentToEdit['student_id']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($studentToEdit['first_name']) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($studentToEdit['last_name']) ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
</div>

<?php include '../footer.php'; ?>