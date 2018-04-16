<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

class UserRegisteredMailTemplate implements MailTemplateInterface
{
    public function getSubject(): string
    {
        return 'Confirm your account!';
    }

    public function getBodyHtml(): string
    {
        return '<strong>Your account!</strong>';
    }

    public function getBodyText(): string
    {
        return 'Your account!';
    }
}
