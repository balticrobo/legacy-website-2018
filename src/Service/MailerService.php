<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Model\Mail\MailRecipientInterface;
use BalticRobo\Website\Model\Mail\MailTemplateInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailerService
{
    private $mailer;
    private $eventName;

    public function __construct(\Swift_Mailer $mailer, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->eventName = $translator->trans('_common.event_name');
    }

    public function sendMail(MailRecipientInterface $recipient, MailTemplateInterface $mail): void
    {
        $message = (new \Swift_Message())
            ->setFrom('no-reply@baltyckiebitwyrobotow.pl', $this->eventName)
            ->setTo($recipient->getEmail(), $recipient->getName())
            ->setSubject($mail->getSubject())
            ->setBody($mail->getBodyHtml(), 'text/html')
            ->addPart($mail->getBodyText(), 'text/plain');

        $this->mailer->send($message);
    }
}
