<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\User;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserLoginDTO
{
    private $email;
    private $plainPassword;

    public static function createFromAuthenticationUtils(AuthenticationUtils $authenticationUtils): self
    {
        $dto = new self();
        $dto->setEmail($authenticationUtils->getLastUsername());

        return $dto;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPassword(string $password): void
    {
        $this->plainPassword = $password;
    }
}
