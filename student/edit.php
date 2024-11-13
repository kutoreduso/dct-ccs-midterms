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

    // Search for the student in the session data
    foreach ($_SESSION['student_data'] as $key => $student) {
        if ($student['student_id'] === $student_id) {
            $studenttoedit = $student;
            $studentindex = $key;
            break; // Ensure the loop stops when student is found
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    // Get form data
    $updatedData = [
        'student_id' => $_POST['student_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ];

    // Initialize the $errors array (can be expanded for other validation)
    $errors = [];

    // Validate first name and last name fields
    if (empty($_POST['first_name'])) {
        $errors[] = "First name is required.";
    }

    if (empty($_POST['last_name'])) {
        $errors[] = "Last name is required.";
    }

    // If there are no errors, update the session data
    if (empty($errors)) {
        $_SESSION['student_data'][$studentindex] = $updatedData;
        
        // Redirect after successful update
        header("Location: register.php");
        exit;
    }
}
?>

<div class="card p-3 container mt-5">
    <h2>Edit Student</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
        </ol>
    </nav>

    <!-- Error messages will display here if there are any -->
    <?php if(!empty($errors)) : ?>
    <div class="alert alert-danger">
        <strong>System Errors</strong>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Form to edit the student data -->
    <?php if ($studenttoedit): ?>  <!-- Check if student data exists -->
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

            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    <?php endif; ?>  <!-- Correctly close the if block -->

</div>

<?php include '../footer.php'; ?>
