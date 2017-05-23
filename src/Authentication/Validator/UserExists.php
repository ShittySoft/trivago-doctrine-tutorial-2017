<?php

namespace Authentication\Validator;

interface UserExists
{
    public function __invoke(string $emailAddress) : bool;
}
