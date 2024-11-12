<?php 

function getUsers() {
    return [
        ["email" => "user1@example.com", "password" => "user1"],
        ["email" => "user2@example.com", "password" => "user2"],
        ["email" => "user3@example.com", "password" => "user3"],
        ["email" => "user4@example.com", "password" => "user4"],
        ["email" => "user5@example.com", "password" => "user5"]
    ];
}

function validateLoginCredentials($email, $password) {
    $errors = [];
}

if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid Email";
} else {
    $users = getUsers();
    $emailExists = false;

    foreach ($users as $user) {
        foreach($user['email'] === $email) {
            $emailExists = true;
            break;
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

?>