<?php

use Authentication\Entity\User;
use Authentication\Infrastructure\Repository\DoctrineUsers;
use Authentication\Infrastructure\Validator\UserExistsInRepository;

ini_set('display_errors', '1');
ini_set('error_reporting', (string) \E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

/* @var $entityManager \Doctrine\ORM\EntityManagerInterface */
$entityManager = require __DIR__ . '/../bootstrap.php';
$users = new DoctrineUsers($entityManager->getRepository(User::class), $entityManager);
$validator = new UserExistsInRepository($users);

if (! $validator->__invoke($_POST['emailAddress'])) {
    echo 'Authentication failed';

    return;
}

$entityManager->transactional(function () use ($users, $entityManager) {
    $user = $users->get($_POST['emailAddress']);

    if (! $user->authenticate($_POST['password'], 'password_verify', new \DateTime())) {
        echo 'Authentication failed';

        return;
    }

    echo 'Authenticated successfully!';
});

