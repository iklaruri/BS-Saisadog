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
        $sql = "SELECT prod.id,prod.nombre AS producto,prod.stock,tip.nombre AS tipo,gal.ruta
                    FROM App\Entity\Producto prod 
                    INNER JOIN prod.codtipoProducto tip
                    INNER JOIN prod.codartista art
                    INNER JOIN App\Entity\ProductoGenero prodGen WITH prod.id=prodGen.codproducto     
                    INNER JOIN App\Entity\Galeria gal WITH prod.id=gal.codproducto       
                    WHERE prodGen.codgenero=:codGenero
                    AND prod.stock > 0                     
                    ORDER BY prod.nombre";
        $query = $this->entityManager->createQuery($sql)->setParameter('codGenero', $codGenero);
        return $query->execute();
    }


}