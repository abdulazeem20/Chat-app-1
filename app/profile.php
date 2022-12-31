<?php
require_once __DIR__ . "/api.php";

if (!isset($_SESSION['userId'])) {
    location('signin.php');
}

$users = new User();
$user = $users->fetchUserById(['ussid' => $_SESSION["userId"]]);
$friend = "";
$title = 'My Profile';

if (
    isset($_GET['ussid'])
    && isset($_GET['username'])
) {
    $friend = $users->fetchUserById(['ussid' => get('ussid')]);
    if ($friend['username'] === get('username')) {
        $title = $friend['username'] . '\'s Profile';
    } else {
        header('Location: home.php');
    }
}

$ussidSet = isset($_GET['ussid']);
$usernameSet = isset($_GET['username']);

require_once(__DIR__ . '/src/twig.connector.php');
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/template');
$twig = new \Twig\Environment($loader);
$template =  $twig->load('profile.html');
echo $template->render(
    [
        'title' => $title,
        'user' => $user,
        'ussidSet' => $ussidSet,
        'usernameSet' => $usernameSet,
        'friend' => $friend
    ]
);
