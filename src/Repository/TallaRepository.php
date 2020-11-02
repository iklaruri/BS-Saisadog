<?php

namespace App\Repository;

use App\Entity\Talla;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TallaRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * TallaRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Talla::class);
        $this->entityManager = $this->getEntityManager();
    }


}