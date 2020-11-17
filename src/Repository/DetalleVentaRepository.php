<?php

namespace App\Repository;

use App\Entity\DetalleVenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DetalleVentaRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * DetalleVentaRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleVenta::class);
        $this->entityManager = $this->getEntityManager();
    }

   
    public function findDetalleVentasByVenta($codVenta,$fecha): array
    {
        $sql = "SELECT det.id,prod.nombre AS producto,art.nombre AS artista,his.precio,det.cantidad,gal.ruta AS imagen,det.talla
                    FROM App\Entity\DetalleVenta det 
                    INNER JOIN det.codventa ven
                    INNER JOIN det.codproducto prod     
                    INNER JOIN App\Entity\Artista art WITH prod.codartista=art.id              
                    INNER JOIN App\Entity\Galeria gal WITH prod.id=gal.codproducto
                    INNER JOIN App\Entity\Historial his WITH prod.id=his.codproducto                                                        
                    WHERE det.codventa=:codVenta 
                    AND his.fecha LIKE :fecha
                    ";


        $query = $this->entityManager->createQuery($sql)->setParameters(['codVenta' => $codVenta,'fecha' => $fecha.'%']);
        return $query->execute();
    }


}
