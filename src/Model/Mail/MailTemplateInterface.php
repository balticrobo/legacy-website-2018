<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

interface MailTemplateInterface
{
    public function getSubject(): string;

    public function getBodyHtml(): string;

    public function getBodyText(): string;
}
