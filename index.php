<?php
session_start();

$pageTitle = "Log In";

include("header.php");
include('function.php');

// Redirect user if already logged in
if (!empty($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$notification = null;

// Only process the form when the user submits
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the login credentials
    $errors = validateLoginCredentials($email, $password);
    
    if (empty($errors)) {
        $users = getUsers();
        
        // Check the provided email and password
        if (checkLoginCredentials($email, $password, $users)) {
            $_SESSION['email'] = $email;
            $_SESSION['current_page'] = 'dashboard.php';
            header("Location: dashboard.php");
            exit;
        } else {
            $notification = 'Invalid email or password.'; // Login failure message
        }
    }
}
?>
    <main>
    <div class="container">
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($notification)): ?>
        <div class="col-md-4 mb-3 mx-auto col-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>System Error:</strong>
                <?php echo htmlspecialchars($notification); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($errors)): ?>
        <div class="col-md-4 mb-3 mx-auto col-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <?php echo displayErrors($errors); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    
<form method= "POST" action="">
  <div class="p-4">
  <div class="card col-3 mx-auto">
  <div class="card-header fs-3 fw-bold">
    Login
  </div>
  <div class="card-body">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="password">
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
</form>
</main>
<?php 
    include("footer.php");
    ?>