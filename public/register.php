<?php

use Authentication\Entity\User;
use Authentication\Infrastructure\Repository\FilesystemUsers;

require_once __DIR__ . '/../vendor/autoload.php';

$users = new FilesystemUsers(__DIR__ . '/../data/users');

$users->add(User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    function (string $password) : string {
        return password_hash($password, \PASSWORD_DEFAULT);
    }
));
