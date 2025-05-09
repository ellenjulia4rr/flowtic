<?php

namespace App\Entity;

use App\Constants\SerializerGroups;
use App\Entity\Trait\IDTrait;
use App\Entity\Trait\StatusTrait;
use App\Entity\Trait\ToArrayTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

#[ORM\Entity]
#[ORM\Table(name: 'services')]
class Service
{
    use IDTrait, StatusTrait, ToArrayTrait;

    #[ORM\Column]
    private ?string $description = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Serializer\Groups([SerializerGroups::DEFAULT])]
    private ?float $price = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $duration = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
}