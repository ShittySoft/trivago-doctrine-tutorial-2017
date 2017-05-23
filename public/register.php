<?php

use Authentication\Entity\User;
use Authentication\Infrastructure\Repository\FilesystemUsers;
use Authentication\Infrastructure\Validator\UserExistsInRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$users = new FilesystemUsers(__DIR__ . '/../data/users');

$validator = new UserExistsInRepository($users);

if ($validator->__invoke($_POST['emailAddress'])) {
    echo 'This user already exists';

    return;
}

$users->add(User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    function (string $password) : string {
        return password_hash($password, \PASSWORD_DEFAULT);
    },
    $validator
));

echo 'Registered successfully!';
