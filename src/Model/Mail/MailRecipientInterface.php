<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\Mail;

interface MailRecipientInterface
{
    public function getEmail(): string;

    public function getName(): string;
}
