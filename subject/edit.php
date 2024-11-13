<?php 
    session_start();
    $pagetitle = "Delete Subject";
    include '../header.php';
    include '../function.php';

    if(empty($_SESSION['email'])) {
        header("Location: ../index.php");
        exit;
    }

    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false); 
    header("Pragma: no-cache");

    checkUserSessionIsActive();  
    guard();   

    $errors = [];
    $subjecttoedit = null;
    $subjectindex = null;

    if(isset($_REQUEST['subject_code'])) {
        $subject_code = $_REQUEST['subject_code'];

        foreach($_SESSION['subject_data'] as $key => $subject) {
            if($subject['subject_code'] === $subject_code) {
                $subjecttoedit = $subject;
                $subjectindex = $key;
                break;
            }
        }
    }
?>
<div class="container mt-5">
    <h2 class="fw-bold">Edit Subject</h2>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="add.php">Add Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
        </ol>
    </nav>
    <hr>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <strong>System Errors</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($subjecttoedit): ?>
        <form action="edit.php?subject_code=<?= urlencode($subjecttoedit['subject_code']) ?>" method="post">
            <div class="form-group">
                <label for="subject_code">Subject Code</label>
                <input type="text" class="form-control" id="subject_code" name="subject_code" value="<?= htmlspecialchars($subjecttoedit['subject_code']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="subject_name">Subject Name</label>
                <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?= htmlspecialchars($subjecttoedit['subject_name'] ?? '') ?>">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Update Subject</button>
        </form>
    <?php else: ?>
        <p class="text-danger">Subject not found.</p>
        <a href="register.php" class="btn btn-primary">Back to Subject List</a>
    <?php endif; ?>
</div>

<?php include '../footer.php'; ?>
