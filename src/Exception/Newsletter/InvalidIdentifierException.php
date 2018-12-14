<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\Newsletter;

final class InvalidIdentifierException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('newsletter.invalid_identifier');
    }
}
