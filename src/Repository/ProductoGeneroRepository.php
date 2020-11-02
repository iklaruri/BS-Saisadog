<?php

namespace App\Repository;

use App\Entity\ProductoGenero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductoGeneroRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * ProductoGeneroRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductoGenero::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findProductosByGenero($codGenero): array
    {
        $sql = "SELECT prod.id,prod.nombre,prod.stock
                    FROM App\Entity\ProductoGenero prodGen
                    JOIN prodGen.codproducto prod
                    JOIN prodGen.codgenero gen         
                    JOIN prod.codartista            
                    WHERE prodGen.codgenero=:codGenero
                    AND prod.stock > 0
                    ORDER BY prod.nombre";
        $query = $this->entityManager->createQuery($sql)->setParameter('codGenero', $codGenero);
        return $query->execute();
    }


}