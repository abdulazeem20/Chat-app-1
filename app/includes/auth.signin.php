<?php

$success = $error = "";
$result = [];

$data = [];
$data['username'] = post('username');
$data['password'] = post('password');

$auth = new Auth($data);
$user = new User($data);

if ($auth->checkSiginInEmpty()) {
    $error = "Input All Fields";
} else {
    $users = $user->fetchUser();
    if ($users) {
        if ($users['password'] === md5($data['password'])) {
            $_SESSION['userId'] = $users['ussid'];
            $user->saveOnline($users['ussid']);
            $success = "Data Sucessfully Validated !!!";
        } else {
            $error = "Invalid Username Or Password";
        }
    } else {
        $error = "Invalid Login Detail";
    }
}

if ($success) {
    $result['output'] = $success;
    $result['status'] = 'success';
    echo json_encode($result);
} elseif ($error) {
    $result['output'] = $error;
    $result['status'] = 'error';
    echo json_encode($result);
}