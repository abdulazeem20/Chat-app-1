<?php
$success = $error = "";
$result = [];

$data = [];
$data['firstname'] = post('firstname');
$data['lastname'] = post('lastname');
$data['email'] = post('email');
$data['gender'] = post('gender');
$data['phonenumber'] = post('phonenumber');
$data['username'] = post('username');
$data['password1'] = post('password1');
$data['password2'] = post('password2');

$auth = new Auth($data);
$user = new User($data);

if ($auth->checkSiginUpEmpty()) {
    $error = "Input All Fields";
} else if ($user->checkIfEmailExists()) {
    $error = "Email Aready Exists";
} else if ($auth->validateEmail()) {
    $error = "Invalid Email Address";
} else if ($user->checkIfPhonenumberExists()) {
    $error = "PhoneNumber Aready Exists";
} else if ($user->checkIfUsernameExists()) {
    $error = "username Aready Exists";
} else if ($data['password1'] !== $data['password2']) {
    $error = "Password Mismatch";
} else {
    $insert = $user->insertUser();
    if ($insert) {
        $success = "Your data's have been sucessfully validated and saved";
    } else {
        $error = "An error Occoured Kindly try again";
    }
}

if ($success) {
    $result['output'] = $success;
    $result['status'] = 'success';
    echo json_encode($result);
} elseif ($error) {
    # code...
    $result['output'] = $error;
    $result['status'] = 'error';
    echo json_encode($result);
}
