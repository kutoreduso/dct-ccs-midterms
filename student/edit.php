<?php
session_start();
$pageTitle = "Edit Student";
include '../header.php';
include '../function.php';
guard();

$errors = [];
$studenttoedit = null;
$studentindex = null;

if (isset($_REQUEST['student_id'])) {
    $student_id = $_REQUEST['student_id'];

    foreach ($_SESSION['student_data'] as $key => $student) {
        if ($student['student_id'] === $student_id) {
            $studenttoedit = $student;
            $studentindex = $key;
            break; // Make sure to close the loop
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) { // Corrected 'REQUEST_METHODS' to 'REQUEST_METHOD'
    $updatedData = [
        'student_id' => $_POST['student_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ];

    // Initialize the $errors array (if necessary, can be expanded for validation)
    $errors = [];

    // Ensure no output before this point
    if (empty($errors)) {
        $_SESSION['student_data'][$studentindex] = $updatedData;

        // Make sure there are no errors in the header function
        header("Location: register.php");
        exit;
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

    <form action="edit.php?student_id=<?= urlencode($studenttoedit['student_id']) ?>" method="post">
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($studenttoedit['student_id']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($studenttoedit['first_name']) ?>">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($studenttoedit['last_name']) ?>">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>

<?php include '../footer.php'; ?>
