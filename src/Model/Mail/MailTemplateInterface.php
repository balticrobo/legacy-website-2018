<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Mail;

interface MailTemplateInterface
{
    public function getTemplateName(): string;

    public function getSubjectKey(): string;

    public function getParameters(): array;
}
