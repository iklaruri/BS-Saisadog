<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductoRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * ProductoRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findProductosByArtista($codArtista): array
    {
        $sql = "SELECT prod.id,prod.nombre,prod.stock,tip.nombre AS tipo
                    FROM App\Entity\Producto prod 
                    INNER JOIN prod.codtipoProducto tip
                    INNER JOIN prod.codartista art
                    WHERE art.id=:codArtista
                    AND prod.stock > 0                     
                    ORDER BY prod.nombre";
        $query = $this->entityManager->createQuery($sql)->setParameter('codArtista', $codArtista);
        return $query->execute();
    }

    public function findProductosByTipo($codTipo): array
    {
        $sql = "SELECT prod.id,prod.nombre,prod.stock,art.nombre
                    FROM App\Entity\Producto prod                                       
                    INNER JOIN prod.codtipoProducto tip
                    INNER JOIN prod.codartista art
                    WHERE tip.id=:codTipo
                    AND prod.stock > 0                     
                    ORDER BY prod.nombre";
        $query = $this->entityManager->createQuery($sql)->setParameter('codTipo', $codTipo);
        return $query->execute();
    }


}