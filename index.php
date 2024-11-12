
<?php 
session_start();

$pageTitle="Log In";

    include("header.php");
    include('function.php');


    if (!empty($_SESSION['email'])) {
        header("Location: dashboard.php");
        exit;
    }

    $errors = [];
    $notification = null;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        $errors = validateLoginCredentials($email, $password); // Fix: added semicolon here
    
        if (empty($errors)) {
            $users = getUsers();
            if (checkLoginCredentials($email, $password, $users)) {
                $_SESSION['email'] = $email;
                $_SESSION['current_page'] = 'dashboard.php';
                header("Location: dashboard.php");
                exit;
            } else {
                $notification = '<li> Invalid Email.</li>';
            }
        }
    }
    ?>
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

<?php 
    include("footer.php");
