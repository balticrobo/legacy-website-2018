<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\Newsletter;

use BalticRobo\Website\Adapter\FormValidation as OwnAssert;
use Symfony\Component\Validator\Constraints as Assert;

final class NewsletterEmailDTO
{
    /**
     * @Assert\NotBlank(message="newsletter.email.not_blank")
     * @Assert\Length(
     *     min=5, minMessage="newsletter.email.length.min",
     *     max=80, maxMessage="newsletter.email.length.max"
     * )
     * @Assert\Email(message="newsletter.email.email")
     * @OwnAssert\NewsletterEmailExists(message="newsletter.email.already_exists")
     */
    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
