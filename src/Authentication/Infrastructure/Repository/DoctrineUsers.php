<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

final class DoctrineUsers implements Users
{
    /**
     * @var ObjectRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectRepository $repository, ObjectManager $objectManager)
    {
        $this->repository = $repository;
        $this->objectManager = $objectManager;
    }

    public function get(string $emailAddress): User
    {
        $object = $this->repository->find($emailAddress);

        if (! $object instanceof User) {
            throw new \UnexpectedValueException(sprintf(
                'Couldn\'t find user by email "%s"',
                $emailAddress
            ));
        }

        return $object;
    }

    public function add(User $user): void
    {
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }
}