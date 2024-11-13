<?php
session_start();
$pagetitle = "Register Student";
include ('../header.php');
include ('../function.php');
guard();

$errors = [];
$student_data = [];

if (!isset($_SESSION['student_data'])) {
    $_SESSION['student_data'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_data = [
        'student_id' => $_POST['student_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
    ];

    $errors = validateStudentData($student_data);

    if (empty($errors)) {
        $duplicate_index = getSelectedStudentIndex($student_data['student_id']);
        if ($duplicate_index !== null) {
            $errors[] = "Student ID " . htmlspecialchars($student_data['student_id']) . " already exists.";
        } else {
            $_SESSION['student_data'][] = $student_data;
            header("Location: register.php");
            exit;
        }
    }
}
?>

<div class="container mt-5">

    <h2 class="fw-bold">Register a New Student</h2>
    <br>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Register Student</li>
        </ol>
    </nav>
    <hr>
    <br>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>System Errors</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="register.php" method="post">
        <div class="form-group">
            <label for="student_id">Student ID</label>
            <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
    <hr>
    <h3 class="mt-5 fw-bold">Student List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($_SESSION['student_data'])): ?>
                <?php foreach ($_SESSION['student_data'] as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                        <td>
                            <a href="edit.php?student_id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-info btn-sm fw-bold">Edit</a>
                            <a href="delete.php?student_id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-danger btn-sm fw-bold">Delete</a>
                            <a href="attach-subject.php?student_id=<?php echo urlencode($student['student_id']); ?>" class="btn btn-warning btn-sm fw-bold">Attach Subject</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>