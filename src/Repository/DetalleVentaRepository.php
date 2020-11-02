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

    public function findVentasByUsuario($codUsuario): array
    {
        $sql = "SELECT ven.id AS idVenta,ven.fecha,ven.preciofinal,det.id AS idDetVenta,det.cantidad,prod.nombre,prod.id AS idProducto
                    FROM App\Entity\DetalleVenta det 
                    INNER JOIN det.codproducto prod
                    INNER JOIN det.codventa ven
                    WHERE ven.codusuario=:codUsuario                               
                   ";
        $query = $this->entityManager->createQuery($sql)->setParameter('codUsuario', $codUsuario);
        return $query->execute();
    }

    public function findVentasByUsuarioFecha($codUsuario,$fecha): array
    {
        $sql = "SELECT ven.id AS idVenta,ven.fecha,ven.preciofinal,det.id AS idDetVenta,det.cantidad
                    FROM App\Entity\DetalleVenta det 
                    INNER JOIN det.codventa ven
                    INNER JOIN det.codproducto prod
                    WHERE ven.codusuario=:codUsuario       
                    AND ven.fecha LIKE :fecha";

        $query = $this->entityManager->createQuery($sql)->setParameters(['codUsuario' => $codUsuario,'fecha' => $fecha.'%']);
        return $query->execute();
    }


}