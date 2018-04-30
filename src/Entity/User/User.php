<?php

declare(strict_types = 1);

namespace BalticRobo\Website\Entity\User;

use BalticRobo\Website\Model\Mail\MailRecipientInterface;
use BalticRobo\Website\Model\User\UserRegisterDTO;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements AdvancedUserInterface, MailRecipientInterface
{
    private const TOKEN_VALIDATION_PERIOD = '1 day';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $forename;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $tokenRequestedAt;

    /**
     * @ORM\Column(type="timestamp_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="timestamp_immutable", nullable=true)
     */
    private $lastLoginAt;

    public static function createFromRegisterDTO(UserRegisterDTO $dto, string $token, \DateTimeImmutable $now): self
    {
        $entity = new self();
        $entity->forename = $dto->getForename();
        $entity->surname = $dto->getSurname();
        $entity->email = $dto->getEmail();
        $entity->plainPassword = $dto->getPassword();
        $entity->active = false;
        $entity->roles = ['ROLE_USER'];
        $entity->token = $token;
        $entity->tokenRequestedAt = $now;
        $entity->createdAt = $now;

        return $entity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getForename(): string
    {
        return $this->forename;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getName(): string
    {
        return "{$this->forename} {$this->surname}";
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return array_unique(array_merge(['ROLE_USER'], $this->roles));
    }

    public function addRole(string $role): void
    {
        $this->roles = array_unique(array_merge([$role], $this->roles));
    }

    public function removeRole(string $role): void
    {
        $key = array_search($role, $this->roles, true);
        if ($key === false) {
            return;
        }
        unset($this->roles[$key]);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $encodedPassword): void
    {
        $this->password = $encodedPassword;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function isAccountNonExpired(): bool
    {
        return $this->active;
    }

    public function isAccountNonLocked(): bool
    {
        return $this->active;
    }

    public function isCredentialsNonExpired(): bool
    {
        return $this->active;
    }

    public function isEnabled(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token, \DateTimeImmutable $now): void
    {
        $this->token = $token;
        $this->tokenRequestedAt = $now;
    }

    public function unsetToken(): void
    {
        $this->token = null;
    }

    public function isTokenValid(): bool
    {
        $interval = \DateInterval::createFromDateString(self::TOKEN_VALIDATION_PERIOD);

        return $this->getTokenRequestedAt()->add($interval) >= new \DateTimeImmutable();
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function activate(): void
    {
        $this->active = true;
        $this->unsetToken();
        $this->addRole('ROLE_COMPETITOR');
    }

    private function getTokenRequestedAt(): \DateTimeImmutable
    {
        return $this->tokenRequestedAt;
    }
}
