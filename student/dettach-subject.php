<?php 
    session_start();
    $pagetitle = "Detach Subject from Student";
    include '../header.php';
    include '../function.php';

    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false); 
    header("Pragma: no-cache");

    checkUserSessionIsActive();  
    guard(); 

    $studenttodelete = null;
    $subjecttodetach = null;

    if(isset($_GET['student_id']) && isset($_GET['subject_code'])) {
        $student_id = $_GET['student_id'];
        $subject_code = $_GET['subject_code'];

        if (!empty($_SESSION['student_data'])) {
            foreach ($_SESSION['student_data'] as $student) {
                if ($student['student_id'] === $student_id) {
                    $studenttodelete = $student;
                    break;
                }
            }
        }
        if (!empty($_SESSION['subject_data'])) {
            foreach ($_SESSION['subject_data'] as $subject) {
                if($subject['subject_code'] === $subject_code) {
                    $subjecttodetach = $subject;
                    break;
                }
            }
        }
    } else {
        header("Location: register.php");
        exit;
    }

    // Debug: Check if the form is being submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id']) && isset($_POST['subject_code'])) {
        // Debug: Print values from POST request
        var_dump($_POST); // Show what data is being posted

        $student_id = $_POST['student_id'];
        $subject_code = $_POST['subject_code'];

        if (!empty($_SESSION['attached_subjects'][$student_id])) {
            // Debug: Show what subjects are attached to the student before detaching
            var_dump($_SESSION['attached_subjects'][$student_id]); 

            $_SESSION['attached_subjects'][$student_id] = array_filter(
                $_SESSION['attached_subjects'][$student_id],
                function ($code) use ($subject_code) {
                    return $code !== $subject_code; // Detach the subject
                }
            );

            // Debug: Show the updated attached subjects after detaching
            var_dump($_SESSION['attached_subjects'][$student_id]);
        }

        // Reindex the array after filtering to ensure proper index values
        $_SESSION['attached_subjects'][$student_id] = array_values($_SESSION['attached_subjects'][$student_id]);

        // Debug: Show updated session data
        var_dump($_SESSION['attached_subjects']);

        // Redirect after detaching
        header('Location: attach-subject.php?student_id=' . urlencode($student_id));
        exit;
    }
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
