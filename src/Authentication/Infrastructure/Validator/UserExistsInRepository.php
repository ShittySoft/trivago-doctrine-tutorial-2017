<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Validator;

use Authentication\Repository\Users;
use Authentication\Validator\UserExists;

final class UserExistsInRepository implements UserExists
{
    /**
     * @var Users
     */
    private $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function __invoke(string $emailAddress): bool
    {
        try {
            $this->users->get($emailAddress);

            return true;
        } catch (\UnexpectedValueException $e) {
            return false;
        }
    }
}
