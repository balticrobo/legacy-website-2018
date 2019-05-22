<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordDTO
{
    /**
     * @Assert\NotBlank(message="user_register.password.not_blank")
     * @Assert\Length(
     *     min=8, minMessage="user_register.password.length.min",
     *     max=30, maxMessage="user_register.password.length.max"
     * )
     */
    private $password;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
