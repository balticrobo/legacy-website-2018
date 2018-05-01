<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Service;

use BalticRobo\Website\Model\Mail\MailRecipientInterface;
use BalticRobo\Website\Model\Mail\MailTemplateInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MailerService
{
    private $mailer;
    private $twig;
    private $translator;
    private $eventName;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->eventName = $translator->trans('_common.event_name');
    }

    public function sendMail(MailRecipientInterface $recipient, MailTemplateInterface $mail): void
    {
        $template = "_email/{$mail->getTemplateName()}-{$this->translator->getLocale()}";
        $message = (new \Swift_Message())
            ->setFrom('noreply@baltyckiebitwyrobotow.pl', $this->eventName)
            ->setTo($recipient->getEmail(), $recipient->getName())
            ->setSubject($this->translator->trans($mail->getSubjectKey(), [], 'emails'))
            ->setBody($this->twig->render("{$template}.html.twig", $mail->getParameters()), 'text/html')
            ->addPart($this->twig->render("{$template}.txt.twig", $mail->getParameters()), 'text/plain');
        $this->mailer->send($message);
    }
}
