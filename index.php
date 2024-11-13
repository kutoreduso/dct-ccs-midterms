<?php
session_start(); 
$pagetitle = "Log In";

if (!empty($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit;
}


include ('function.php'); 
include ('header.php');

$errors = [];
$notification = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['txtEmail'] ?? '';
    $password = $_POST['txtPassword'] ?? '';

    $errors = validateLoginCredentials($email, $password);

    if (empty($errors)) {
        $users = getUsers();
        if (checkLoginCredentials($email, $password, $users)) {
            $_SESSION['email'] = $email;
            $_SESSION['current_page'] = 'dashboard.php'; 
            header("Location: dashboard.php");
            exit;
        } else {
          
            $notification = "<li>Invalid Email.</li>";
        }
    } else {
       
        $notification = displayErrors($errors);
    }
}
?>

<?php include('header.php'); ?>

<div class="container col-4">
    <?php if (!empty($notification)): ?>
        <div class="col-md-8 mb-3 mx-auto">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>System Errors</strong>
                <?php echo $notification; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="card col-md-8 col-lg-8 mx-auto p-4">
            <h1 class="fw-bold text-center">Login</h1>
            <hr>

            <div class="mb-3">
                <label for="txtEmail" class="form-label">Email address</label>
                <input type="text" class="form-control" id="txtEmail" name="txtEmail">
            </div>
            <div class="mb-3">
                <label for="txtPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="txtPassword" name="txtPassword">
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>
</div>

        
<?php include('footer.php'); ?>