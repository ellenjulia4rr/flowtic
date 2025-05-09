<?php

namespace App\Entity;

use App\Entity\Trait\IDTrait;
use App\Entity\Trait\StatusTrait;
use App\Entity\Trait\ToArrayTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'clients')]
class Client
{
    use IDTrait, StatusTrait, ToArrayTrait;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $fullName = null;

    #[ORM\Column(type: Types::STRING, length: 20)]
    private ?string $phone = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private User $user;

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}