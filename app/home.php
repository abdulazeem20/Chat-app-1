<?php
require_once __DIR__ . "/api.php";

if (!isset($_SESSION['userId'])) {
    location('signin.php');
}

$user = new User();

$message = new Message(['ussid' => $_SESSION["userId"]]);

$messages = $message->getChat();
$users = $user->getOtherUsers(['ussid' => $_SESSION['userId']]);

require_once(__DIR__ . '/src/twig.connector.php');
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/template');
$twig = new \Twig\Environment($loader);
$template =  $twig->load('home.html');

echo $template->render(
    [
        'title' => 'Home',
        'users' => $users,
        'messages' => $messages,
        'sessionId' => $_SESSION["userId"]
    ]
);
