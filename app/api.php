<?php
session_start();

require_once __DIR__ . "/class/autoload.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['type']) && $_POST["type"] === 'checkusername') {
        $data = ['username' => post('username')];
        $user = new User($data);
        $result = $user->checkIfUsernameExists();
        echo json_encode($result);
    }

    if (isset($_POST['type']) && $_POST["type"] === 'checkphonenumber') {
        $data = ['phonenumber' => post('phonenumber')];
        $user = new User($data);
        $result = $user->checkIfPhonenumberExists();
        echo json_encode($result);
    }

    if (isset($_POST['type']) && $_POST["type"] === 'checkemail') {
        $data = ['email' => post('email')];
        $user = new User($data);
        $result = $user->checkIfEmailExists();
        echo json_encode($result);
    }

    if (isset($_POST['type']) && $_POST["type"] === 'saveUser') {

        require_once __DIR__ . '/includes/auth.signup.php';
    }

    if (isset($_POST['type']) && $_POST["type"] === 'login') {

        require_once __DIR__ . '/includes/auth.signin.php';
    }

    if (isset($_POST['type']) && $_POST["type"] === 'uploadImage') {
        require_once __DIR__ . '/includes/upload.inc.php';
    }

    if (isset($_POST['type']) && $_POST["type"] === 'search') {
        $data = ['username' => post('search')];
        $user = new User($data);
        $result = $user->searchForUsers($_SESSION["userId"]);
        echo json_encode($result);
    }

    if (isset($_POST['type']) && $_POST['type'] == 'saveMessage') {
        $data = [];
        $data['messages'] = post('textArea');
        $data['receiverId'] = post('incomingId');
        $data['senderId'] = post('outgoingId');
        $message = new Message($data);
        $message->saveMessage();
    }

    if (isset($_POST['type']) && $_POST['type'] == 'getMessage') {
        $data = [];
        $data['senderId'] = post('senderId');
        $data['receiverId'] = post('receiverId');
        $message = new Message($data);
        $response = $message->getMessages();
        echo json_encode($response);
    }

    if (isset($_POST['type']) && $_POST['type'] == 'getChat') {
        $data = [];
        $data['ussid'] = post('id');
        $message = new Message($data);
        $response = $message->getChat();
        echo json_encode($response);
    }

    if (isset($_POST['type']) && $_POST['type'] == 'saveReceived') {
        $data = [
            'ussid' => post('ussid')
        ];
        $message = new Message($data);
        $result = $message->saveReceived();
    }

    if (isset($_POST['type']) && $_POST['type'] == 'saveSeen') {
        $data = [
            'ussid' => post('ussid'),
            'convId' => post('convId'),
        ];
        $message = new Message($data);
        $result = $message->saveSeen();
    }

    if (isset($_POST['type']) && $_POST['type'] == 'getUnreadMessage') {
        $data = [
            'ussid' => post('ussid'),
            'convId' => post('convId'),
        ];
        $message = new Message($data);
        $result = $message->getUnreadMessages();
        echo json_encode($result);
    }

    if (isset($_POST['editUserProfileButton'])) {
        require_once __DIR__ . '/includes/auth.profile.php';
    }
}
