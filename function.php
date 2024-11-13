<?php
function getUsers() {
    return [
        ["email" => "user1@email.com", "password" => "password"],
        ["email" => "user2@email.com", "password" => "password"],
        ["email" => "user3@email.com", "password" => "password"],
        ["email" => "user4@email.com", "password" => "password"],
        ["email" => "user5@email.com", "password" => "password"]
    ];
}

function validateLoginCredentials($email, $password) {
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email.";
    } else {
       
        $users = getUsers();
        $emailExists = false;
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $emailExists = true;
                break;
            }
        }

        if (!$emailExists) {
            $errors[] = "Invalid Email.";
        }
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    return $errors;

}


function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

function checkUserSessionIsActive() {
    if (isset($_SESSION['email']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
        header("Location: dashboard.php");
        exit;
    }
}

function guard() {
    if (empty($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
        header("Location: index.php"); 
        exit;
    }
}


function displayErrors($errors) {
    $output = "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}
function renderErrorsToView($error) {
    if (empty($error)) {
        return null;
    }
    return "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                $error
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

function getBaseURL() {
    return 'http://' . $_SERVER['HTTP_HOST'] . '/midterms';
}

function validateStudentData($student_data) {
    $errors = [];

    if (empty($student_data['student_id'])) {
        $errors[] = "Student ID is required.";
    }
    if (empty($student_data['first_name'])) {
        $errors[] = "First Name is required.";
    }
    if (empty($student_data['last_name'])) {
        $errors[] = "Last Name is required.";
    }

    return $errors;
}

function checkDuplicateStudentData($student_data) {
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $existing_student) {
            if ($existing_student['student_id'] === $student_data['student_id']) {
                return $existing_student;
            }
        }
    }
    return null;
}

function getSelectedStudentIndex($student_id) {
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $index => $student) {
            if ($student['student_id'] === $student_id) {
                return $index;
            }
        }
    }
    return null;
}

function getSelectedStudentData($index) {
    return $_SESSION['student_data'][$index] ?? false;
}
?>