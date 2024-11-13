<?php 
    session_start();
    $pagetitle = "Dettach Subject from Student";
    include '../header.php';
    include '../function.php';


    header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");

checkUserSessionIsActive();  
guard(); 



$studenttodelete = null;
$subjecttodetach = null;




?>

<div class="container mt-5">
    <h2>Detach Subject from Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item"><a href="attach-subject.php">Attach Subject to Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detach Subject from Student</li>
        </ol>
    </nav>

    <div class="card mt-3">
        <div class="card-body">
            <?php if ($studenttodelete && $subjecttodetach): ?>
                <h5>Are you sure you want to detach this subject from this student record?</h5>
                <ul>
                    <li><strong>Student ID:</strong> <?= htmlspecialchars($studenttodelete['student_id']) ?></li>
                    <li><strong>First Name:</strong> <?= htmlspecialchars($studenttodelete['first_name']) ?></li>
                    <li><strong>Last Name:</strong> <?= htmlspecialchars($studenttodelete['last_name']) ?></li>
                    <li><strong>Subject Code:</strong> <?= htmlspecialchars($subjecttodetach['subject_code']) ?></li>
                    <li><strong>Subject Name:</strong> <?= htmlspecialchars($subjecttodetach['subject_name']) ?></li>
                </ul>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($studenttodelete['student_id']) ?>">
                    <input type="hidden" name="subject_code" value="<?= htmlspecialchars($subjecttodetach['subject_code']) ?>">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Detach Subject from Student</button>
                </form>
            <?php else: ?>
                <p class="text-danger">Student or subject not found.</p>
                <a href="register.php" class="btn btn-primary">Back to Student List</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>