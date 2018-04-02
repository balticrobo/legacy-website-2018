<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\DoctrineMapping;

class UnsupportedDatabaseTypeException extends \Exception
{
    public function __construct(string $class)
    {
        parent::__construct("Unsupported database type. Check {$class}:getSQLDeclaration() for more details.");
    }
}
