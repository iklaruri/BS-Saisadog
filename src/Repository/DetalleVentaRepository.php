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


    public function findVentasByUsuarioFecha($codUsuario,$fecha): array
    {
        $sql = "SELECT ven.id AS idVenta,ven.fecha,det.id AS idDetalle,det.cantidad,prod.nombre,his.precio
                    FROM App\Entity\DetalleVenta det 
                    INNER JOIN det.codventa ven
                    INNER JOIN det.codproducto prod
                    INNER JOIN App\Entity\Historial his WITH prod.id=his.codproducto                     
                    WHERE ven.codusuario=:codUsuario 
                    AND his.fecha LIKE :fecha                      
                    ";

        $query = $this->entityManager->createQuery($sql)->setParameters(['codUsuario' => $codUsuario,'fecha' => $fecha.'%']);
        return $query->execute();
    }


}