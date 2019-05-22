<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\User;

use BalticRobo\Website\Adapter\FormValidation as OwnAssert;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegisterDTO
{
    /**
     * @Assert\NotBlank(message="user_register.email.not_blank")
     * @Assert\Length(
     *     min=5, minMessage="user_register.email.length.min",
     *     max=80, maxMessage="user_register.email.length.max"
     * )
     * @Assert\Email(message="user_register.email.email")
     * @OwnAssert\UserExists(message="user_register.email.already_exists")
     */
    private $email;

    /**
     * @Assert\NotBlank(message="user_register.password.not_blank")
     * @Assert\Length(
     *     min=8, minMessage="user_register.password.length.min",
     *     max=30, maxMessage="user_register.password.length.max"
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank(message="user_register.forename.not_blank")
     * @Assert\Length(
     *     min=2, minMessage="user_register.forename.length.min",
     *     max=40, maxMessage="user_register.forename.length.max"
     * )
     */
    private $forename;

    /**
     * @Assert\NotBlank(message="user_register.surname.not_blank")
     * @Assert\Length(
     *     min=2, minMessage="user_register.surname.length.min",
     *     max=80, maxMessage="user_register.surname.length.max"
     * )
     */
    private $surname;

    private $newsletterAndMarketing = false;

    /**
     * @Assert\IsTrue(message="user_register.terms.is_true")
     */
    private $terms = false;

    /**
     * @Assert\IsTrue(message="user_register.gdpr.is_true")
     */
    private $gdpr = false;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getForename(): ?string
    {
        return $this->forename;
    }

    public function setForename(string $forename): void
    {
        $this->forename = $forename;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function isNewsletterAndMarketing(): bool
    {
        return $this->newsletterAndMarketing;
    }

    public function setNewsletterAndMarketing(bool $newsletterAndMarketing): void
    {
        $this->newsletterAndMarketing = $newsletterAndMarketing;
    }

    public function isTerms(): bool
    {
        return $this->terms;
    }

    public function setTerms(bool $terms): void
    {
        $this->terms = $terms;
    }

    public function isGdpr(): bool
    {
        return $this->gdpr;
    }

    public function setGdpr(bool $gdpr): void
    {
        $this->gdpr = $gdpr;
    }
}
