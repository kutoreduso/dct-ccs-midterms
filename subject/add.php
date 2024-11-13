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

$errors = [];
$subject_data = [];

if (!isset($_SESSION['subject_data'])) {
    $_SESSION['subject_data'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_data = [
        'subject_code' => $_POST['subject_code'],
        'subject_name' => $_POST['subject_name']
    ];

    // Use the correct validation function for subject data
    $errors = validateSubjectData($subject_data);

    foreach ($_SESSION['subject_data'] as $existingSubject) {
        if ($existingSubject['subject_code'] === $subject_data['subject_code']) {
            $errors[] = "Duplicate Subject";
            break;
        }
        if ($existingSubject['subject_name'] === $subject_data['subject_name']) {
            $errors[] = "Duplicate Subject";
            break;
        }
    }

    if (empty($errors)) {
        $_SESSION['subject_data'][] = $subject_data;

        // Debugging: Check the session content
        var_dump($_SESSION['subject_data']); 

        // Redirect to the same page after adding the subject
        header("Location: add.php");
        exit;
    }
}

// Function to validate subject data
function validateSubjectData($subject_data) {
    $errors = [];
    if (empty($subject_data['subject_code'])) {
        $errors[] = "Subject Code is required.";
    }
    if (empty($subject_data['subject_name'])) {
        $errors[] = "Subject Name is required.";
    }
    return $errors;
}
?>

<!-- HTML Content Starts Here -->
<div class="card container mt-5">
    <h2 class="fw-bold">Add a New Subject</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
        </ol>
    </nav>
    <hr>
    <?php if(!empty($errors)): ?>
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
