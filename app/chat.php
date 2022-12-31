<?php
require_once __DIR__ . "/api.php";

if (!isset($_SESSION['userId'])) {
    location('signin.php');
}

$user = new User();

$friend = "";
$title = 'Chat';
if (
    isset($_GET['ussid'])
    && isset($_GET['username'])
) {
    $friend = $user->fetchUserById(['ussid' => get('ussid')]);
    if ($friend['username'] === get('username')) {
        $title = $friend['username'] . '\'s Chat';
    } else {
        header('Location: home.php');
    }
} else {
    header('Location: home.php');
}

$conv_id1 = preg_replace(
    "/[^0-9]/",
    0,
    $_SESSION["userId"]
);
$conv_id2 = preg_replace(
    "/[^0-9]/",
    0,
    get('ussid')
);

$convId = $conv_id1 * $conv_id2;


require_once(__DIR__ . '/src/twig.connector.php');
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/template');
$twig = new \Twig\Environment($loader);
$template =  $twig->load('chat.html');
echo $template->render(
    [
        'title' => $title,
        'friend' => $friend,
        'incomingId' => get('ussid'),
        'outgoingId' => $_SESSION["userId"],
        'convId' => $convId
    ]
);
