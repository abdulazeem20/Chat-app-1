<?php
session_start();
require_once __DIR__ . "/class/autoload.php";
if (isset($_SESSION['userId'])) {
    $user = new User();
    $user->saveOffline($_SESSION['userId']);
    session_unset();
    session_destroy();
    location('signin.php');
} else {
    location('signup.php');
}