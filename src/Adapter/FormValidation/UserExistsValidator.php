<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Adapter\FormValidation;

use BalticRobo\Website\Service\User\UserService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UserExistsValidator extends ConstraintValidator
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value && $this->userService->isRegisteredUser($value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
