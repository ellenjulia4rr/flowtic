<?php

namespace App\Service;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use App\Service\AbstractEntityService;
use Doctrine\ORM\EntityManagerInterface;

class ServiceService extends AbstractEntityService
{
    public function __construct(ServiceRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->em = $entityManager;
    }
}