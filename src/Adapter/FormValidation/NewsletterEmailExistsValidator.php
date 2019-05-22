<?php declare(strict_types=1);

namespace BalticRobo\Website\Adapter\FormValidation;

use BalticRobo\Website\Service\NewsletterService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class NewsletterEmailExistsValidator extends ConstraintValidator
{
    private $newsletterService;

    public function __construct(NewsletterService $newsletter)
    {
        $this->newsletterService = $newsletter;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value && $this->newsletterService->isOptedInByEmail($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
