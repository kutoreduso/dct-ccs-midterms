<?php
session_start();
$pageTitle = "Edit Student";
include '../header.php';
include '../function.php';
guard();
?>
<div class="card p-3 container mt-5">
    <h2 class="fw-bold">Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    <div class="card mt-3">
        <div class="card-body">
            <?php if ($studentToDelete): ?>
                <h5>Are you sure you want to delete the following student record?</h5>
                <ul>
                    <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToDelete['student_id']) ?></li>
                    <li><strong>First Name:</strong> <?= htmlspecialchars($studentToDelete['first_name']) ?></li>
                    <li><strong>Last Name:</strong> <?= htmlspecialchars($studentToDelete['last_name']) ?></li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($studentToDelete['student_id']) ?>">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete Student Record</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Student not found.</p>
                <a href="register.php" class="btn btn-primary">Back to Student List</a>
            <?php endif; ?>
        </div>
    </div>
<?php include '../footer.php'; ?>