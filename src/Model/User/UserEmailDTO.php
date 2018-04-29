<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserEmailDTO
{
    /**
     * @Assert\NotBlank(message="user_register.email.not_blank")
     * @Assert\Length(
     *     min=5, minMessage="user_register.email.length.min",
     *     max=80, maxMessage="user_register.email.length.max"
     * )
     * @Assert\Email(message="user_register.email.email")
     */
    private $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
