<?php

use Authentication\Entity\User;
use Authentication\Infrastructure\Repository\DoctrineUsers;
use Authentication\Infrastructure\Repository\FilesystemUsers;
use Authentication\Infrastructure\Validator\UserExistsInRepository;

require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
$entityManager = require __DIR__ . '/../bootstrap.php';
$users = new DoctrineUsers($entityManager->getRepository(User::class), $entityManager);

$validator = new UserExistsInRepository($users);

if ($validator->__invoke($_POST['emailAddress'])) {
    echo 'This user already exists';

    return;
}

$users->store(User::register(
    $_POST['emailAddress'],
    $_POST['password'],
    function (string $password) : string {
        return password_hash($password, \PASSWORD_DEFAULT);
    },
    $validator
));

echo 'Registered successfully!';
