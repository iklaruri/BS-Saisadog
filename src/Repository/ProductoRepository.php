<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    public function findProductosByTermino($termino):array
    {
        $sql = "SELECT prod.id,prod.nombre,prod.stock,art.nombre AS artista,tip.nombre AS tipo,gal.ruta
                    FROM App\Entity\Producto prod 
                    INNER JOIN prod.codtipoProducto tip
                    INNER JOIN prod.codartista art
                    INNER JOIN App\Entity\Galeria gal WITH prod.id=gal.codproducto                    
                    WHERE prod.nombre LIKE :termino
                    AND prod.stock > 0                    
                    ";
        $query = $this->entityManager->createQuery($sql)->setParameter('termino', '%'.$termino.'%');
        return $query->execute();
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


    public function findProductosNovedades(): array
    {
        $sql = "SELECT prod.id,prod.nombre AS producto,prod.stock,art.nombre AS artista,tip.nombre AS tipo,gal.ruta
                    FROM App\Entity\Producto prod                                       
                    INNER JOIN prod.codtipoProducto tip
                    INNER JOIN prod.codartista art  
                    INNER JOIN App\Entity\Galeria gal WITH prod.id=gal.codproducto                 
                    WHERE prod.stock > 0                                        
                    ORDER BY prod.id DESC";
        $query = $this->entityManager->createQuery($sql)->setMaxResults(6);
        return $query->execute();
    }






}