<?php
$success = $error = "";
$result = [];

$data = [];
$data['firstname'] = post('firstname');
$data['lastname'] = post('lastname');
$data['email'] = post('email');
$data['phonenumber'] = post('phonenumber');
$data['username'] = post('username');

$auth = new Auth($data);
$user = new User($data);

if ($auth->checkUpdateEmpty()) {
    $error = "Input All Fields";
} else if ($user->checkIfEmailExists()) {
    $error = "Email Aready Exists";
} else if ($auth->validateEmail()) {
    $error = "Invalid Email Address";
} else if ($user->checkIfPhonenumberExists()) {
    $error = "PhoneNumber Aready Exists";
} else if ($user->checkIfUsernameExists()) {
    $error = "username Aready Exists";
} else {
    $insert = $user->updateProfile($_SESSION['userId']);
    if ($insert) {
        $success = "Your data's have been sucessfully updated ";
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
