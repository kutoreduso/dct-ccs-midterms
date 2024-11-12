<?php
session_start();

$pageTitle = "Log In";

include("header.php");
include('function.php');


if (!empty($_SESSION['txtemail'])) {
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$notification = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['txtemail'] ?? '';
    $password = $_POST['txtpassword'] ?? '';


    $errors = validateLoginCredentials($txtemail, $txtpassword);
    
    if (empty($errors)) {
        $users = getUsers();
        

        if (checkLoginCredentials($txtemail, $txtpassword, $users)) {
            $_SESSION['txtemail'] = $txtemail;
            $_SESSION['current_page'] = 'dashboard.php';
            header("Location: dashboard.php");
            exit;
        } else {
            $notification = 'Invalid email or password.';
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
        

        <form method="POST" action="">
            <div class="p-4">
                <div class="card col-3 mx-auto">
                    <div class="card-header fs-3 fw-bold">
                        Login
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="txtemail" aria-describedby="emailHelp" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="txtpassword" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<?php include("footer.php"); ?>
