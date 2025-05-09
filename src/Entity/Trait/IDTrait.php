<?php

namespace App\Entity\Trait;

use App\Constants\SerializerGroups;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

trait IDTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Serializer\Groups([SerializerGroups::ID])]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}