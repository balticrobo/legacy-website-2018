<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\FormValidation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class TeamExists extends Constraint
{
    public $message = 'Team with this identifier already exists.';
}
