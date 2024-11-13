<?php
// Start the session to maintain user login state
session_start();
$pagetitle = "Attach Subject to Student";

// Include the header and functions files
include '../header.php';
include '../function.php';

// Check if the user is logged in by verifying the session's email; if not, redirect them to the login page
if (empty($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}

// Disable caching to prevent stale data from being shown
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");

// Check if the user session is still active and if the user has access permissions
checkUserSessionIsActive();  
guard();

// Initialize variables to store student data and errors
$studentToAttach = null;
$errors = [];

// Check if a student ID is passed in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Look through the session's student data to find the student with the given ID
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $student) {
            if ($student['student_id'] === $student_id) {
                $studentToAttach = $student; // Found the student, store their data
                break;
            }
        }
    }
}

?>

<!-- Start of HTML content -->

<div class="container mt-5">
    <h2>Attach Subject to Student</h2>
    <br>
    
    <!-- Breadcrumb navigation for easier navigation through the application -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attach Subject to Student</li>
        </ol>
    </nav>
    <hr>
    <br>

    <!-- Display any system errors if present -->
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

    <!-- Display the selected student's information if found -->
    <?php if ($studentToAttach): ?>
        <div class="container">
            <h3>Selected Student Information</h3>
            <ul>
                <li><strong>Student ID:</strong> <?= htmlspecialchars($studentToAttach['student_id']) ?></li>
                <li><strong>Name:</strong> <?= htmlspecialchars($studentToAttach['first_name']) ?> <?= htmlspecialchars($studentToAttach['last_name']) ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <hr>
    <table class="table">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <!-- Static message indicating no subjects are attached -->
            <tr>
                <td colspan="3" class="text-center">No subjects attached.</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Include the footer -->
<?php include '../footer.php'; ?>
