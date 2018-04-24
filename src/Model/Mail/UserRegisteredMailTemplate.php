<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

class UserRegisteredMailTemplate implements MailTemplateInterface
{
    private $activateUrl;

    public function __construct(string $activateUrl)
    {
        $this->activateUrl = $activateUrl;
    }

    public function getTemplateName(): string
    {
        return 'register';
    }

    public function getSubjectKey(): string
    {
        return 'register.subject';
    }

    public function getParameters(): array
    {
        return [
            'activateUrl' => $this->activateUrl,
        ];
    }
}
