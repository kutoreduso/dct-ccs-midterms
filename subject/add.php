<?php
session_start();
$pagetitle="Add Subject"; 
include '../header.php';
include '../function.php';

// Check if user is logged in by checking session email
if(empty($_SESSION['email'])) {
    header("Location: ../index.php"); // Add the missing semicolon here
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
<?php include '../footer.php' ?>