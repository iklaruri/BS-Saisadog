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

    public function findTallasByProducto($codProducto): array
    {
        $sql = "SELECT tall.nombre,tal.stock
                    FROM App\Entity\Talla tal 
                    INNER JOIN tal.codproducto prod
                    INNER JOIN tal.codtallaje tall                   
                    WHERE tal.codproducto=:codProducto
                    AND tal.stock > 0
                    AND prod.codtipoProducto=2";
        $query = $this->entityManager->createQuery($sql)->setParameter('codProducto', $codProducto);
        return $query->execute();
    }


}