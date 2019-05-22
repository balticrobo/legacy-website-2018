<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\FormValidation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserExists extends Constraint
{
    public $message = 'User with this email already exists.';
}
