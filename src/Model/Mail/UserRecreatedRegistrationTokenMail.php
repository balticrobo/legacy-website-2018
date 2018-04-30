<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

class UserRecreatedRegistrationTokenMail implements MailTemplateInterface
{
    private $activateUrl;

    public function __construct(string $activateUrl)
    {
        $this->activateUrl = $activateUrl;
    }

    public function getTemplateName(): string
    {
        return 'recreate-registration-token';
    }

    public function getSubjectKey(): string
    {
        return 'recreate_registration_token.subject';
    }

    public function getParameters(): array
    {
        return [
            'activateUrl' => $this->activateUrl,
        ];
    }
}
