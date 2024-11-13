<?php
session_start(); 
$pagetitle = "Dashboard";
include('header.php');
include('function.php');
if (empty($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}


header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");

checkUserSessionIsActive(); 
guard(); 
?>

    <br>
    <div class=" container d-flex justify-content-between align-items-center col-md-7">
        <h4 class="fs-3 fw-bold">Welcome to the System:</h4>
        <button onclick="window.location.href='logout.php'" class="btn btn-danger">Logout</button>
    </div>
    <br><br>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Add a Subject
                </div>
                <div class="card-body">
                    <p>This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                    <a href="subject/add.php" class="btn btn-primary">Add New Subject</a>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Register a Student
                </div>
                <div class="card-body">
                    <p>This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>

                    <a href="student/register.php" class="btn btn-primary">Register</a>
                </div>
            </div>
        </div>
    </div>
    

<?php
include 'footer.php'; 
?>