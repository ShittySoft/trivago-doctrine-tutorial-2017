<?php

namespace Authentication\Entity;

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
        callable $hashingMechanism
    ) : self {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid email "%s" provided',
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
