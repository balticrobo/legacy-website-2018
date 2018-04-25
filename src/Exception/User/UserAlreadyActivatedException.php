<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\User;

class UserAlreadyActivatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('exception.user.user_already_activated');
    }
}
