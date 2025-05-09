<?php

namespace App\Service;

use App\Filter\AbstractFilter;
use App\Repository\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class AbstractEntityService
{
    protected AbstractRepository $repository;
    protected EntityManagerInterface $em;

    public function findByFilter(AbstractFilter $filter): Query
    {
        return $this->repository->findByFilter($filter);
    }

    public function save($entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}