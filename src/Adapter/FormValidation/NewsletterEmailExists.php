<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\FormValidation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class NewsletterEmailExists extends Constraint
{
    public $message = 'This Email already exists on newsletter list.';
}
