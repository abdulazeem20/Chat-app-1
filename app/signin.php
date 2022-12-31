<?php
require_once __DIR__ . "/api.php";

if (isset($_SESSION['userId'])) {
    location('home.php');
}

require_once(__DIR__ . '/src/twig.connector.php');
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/src/template');
$twig = new \Twig\Environment($loader);
$template =  $twig->load('signin.html');
echo $template->render(
    [
        'title' => 'Sign-in'
    ]
);