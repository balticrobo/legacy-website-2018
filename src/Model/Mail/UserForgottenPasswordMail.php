<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

class UserForgottenPasswordMail implements MailTemplateInterface
{
    private $activateUrl;

    public function __construct(string $activateUrl)
    {
        $this->activateUrl = $activateUrl;
    }

    public function getTemplateName(): string
    {
        return 'forgotten-password';
    }

    public function getSubjectKey(): string
    {
        return 'forgotten_password.subject';
    }

    public function getParameters(): array
    {
        return [
            'activateUrl' => $this->activateUrl,
        ];
    }
}
