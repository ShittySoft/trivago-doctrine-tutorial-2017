<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Repository;

use Authentication\Entity\User;
use Authentication\Repository\Users;

final class FilesystemUsers implements Users
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function get(string $emailAddress): User
    {
        throw new \BadMethodCallException();
    }

    public function add(User $user): void
    {
        $id = $user->id();

        if (file_exists($this->path . '/' . $id)) {
            throw new \InvalidArgumentException(sprintf(
                'User "%s" already exists',
                $id
            ));
        }

        file_put_contents($this->path . '/' . $id, serialize($user));
    }
}