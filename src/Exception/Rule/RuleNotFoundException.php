<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Exception\Rule;

class RuleNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('exception.rule.rule_not_found');
    }
}
