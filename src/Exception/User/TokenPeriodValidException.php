<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\User;

class TokenPeriodValidException extends \Exception
{
    public function __construct()
    {
        parent::__construct('exception.user.token_period_valid');
    }
}
