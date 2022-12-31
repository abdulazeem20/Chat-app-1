<?php

$success = $error = "";
$result = [];

$user = new User();
$info = $user->fetchUserById([
    'ussid' => $_SESSION['userId']
]);
$fileName = $_FILES['img']['name'];
$fileSize = $_FILES['img']['size'];
$fileTmp = $_FILES['img']['tmp_name'];
$ufileType = $_FILES['img']['type'];
$fileType = ['image/png', 'image/jpg', 'image/jpeg'];

$upload = new UploadedFile(
    $fileName,
    $fileSize,
    $fileTmp,
    $ufileType,
    $fileType,
    $info['username'],
    16384,
    __DIR__ . '/../src/template/static/images'
);
if (empty($fileName)) {
    $error =  'No file Selected yet';
} else if ($upload->checkFileExtension()) {
    $error = "Image Must be in PNG or JPG format";
} else if ($upload->checkFileSize()) {
    $error = "Image size Must be of a mximunm of 16kb";
} else {
    $uploadImage = $upload->uploadFile();
    if ($uploadImage) {
        $image = $upload->fileSavedName();
        $user = new User();
        $update = $user->updateProfileImage([
            'ussid' => $_SESSION["userId"],
            'image' => $image
        ]);
        if ($update) {
            $success = "Image Sucessfully Updated";
        } else {
            $error = "An error occured";
        }
    } else {
        $error = "An error Occured";
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