<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Model\User;

class UserLoginDTO
{
    private $username;
    private $plainPassword;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
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
