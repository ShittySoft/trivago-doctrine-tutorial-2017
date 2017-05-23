<?php

namespace Authentication\Entity;

use Authentication\Validator\UserExists;

class User
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $passwordHash;

    private function __construct(string $email, string $passwordHash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public static function register(
        string $email,
        string $password,
        callable $hashingMechanism,
        UserExists $userExists
    ) : self {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid email "%s" provided',
                $email
            ));
        }

        if ($userExists->__invoke($email)) {
            throw new \InvalidArgumentException(sprintf(
                'User with email "%s" is already registered',
                $email
            ));
        }

        return new self($email, $hashingMechanism($password));
    }

    public function id() : string
    {
        return $this->email;
    }
}
