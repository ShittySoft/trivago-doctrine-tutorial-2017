<?php

namespace Authentication\Entity;

use Ramsey\Uuid\Uuid;

class LoginAttempt
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $time;

    /**
     * @var bool
     */
    private $succeeded;

    private function __construct(
        User $user,
        \DateTime $time,
        bool $succeeded
    ) {
        $this->id   = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->time = $time;
        $this->succeeded = $succeeded;
    }

    public static function fromLogin(
        User $user,
        \DateTime $time,
        bool $succeeded
    ) : self {
        return new self($user, $time, $succeeded);
    }
}
