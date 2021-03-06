<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\User;

class InvalidTokenException extends \Exception
{
    public function __construct()
    {
        parent::__construct('user.invalid_token');
    }
}
