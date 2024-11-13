<?php
session_start();
$pagetitle = "Add Subject"; 
include '../header.php';
include '../function.php';

// Check if user is logged in by checking session email
if (empty($_SESSION['email'])) {
    header("Location: ../index.php"); 
    exit; // Ensure the script halts after redirection
}

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

checkUserSessionIsActive();
guard();

$errors = []; // Fixed typo (erros -> errors)
$subject_data = [];

?>

<!-- HTML Content Starts Here -->
<div class="container mt-5">
    <h2 class="fw-bold">Add a New Subject</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>
    <hr>

    <form method="post">
        <div class="form-group">
            <label for="subject_code">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" placeholder="Enter Subject Code">
        </div>
        <div class="form-group">
            <label for="subject_name">Subject Name</label>
            <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter Subject Name">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Add Subject</button>
    </form>
    <hr>
    <h3 class="mt-5">Subject List</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Ensure the correct session key is used and check if the subjects are set
            if (!empty($_SESSION['subject_data'])): 
                foreach ($_SESSION['subject_data'] as $subject): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['subject_name']); ?> </td>
                        <td>
                            <a href="edit.php?subject_code=<?php echo urlencode($subject['subject_code']);?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="delete.php?subject_code=<?php echo urlencode($subject['subject_code']);?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No subjects available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../footer.php'; ?>
