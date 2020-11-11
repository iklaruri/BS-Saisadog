<?php


namespace App\Repository;


use App\Entity\Historial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;


class HistorialRepository extends ServiceEntityRepository
{

    private $entityManager;

    /**
     * HistorialRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historial::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findPrecioByProducto($codProducto,$fecha)
    {
        $sql = "SELECT his.precio,his.esoferta
                    FROM App\Entity\Historial his                   
                    WHERE his.codproducto=:codProducto
                    AND his.fecha LIKE :fecha
                    ORDER BY his.fecha DESC";
        try {
            return $query = $this->entityManager->createQuery($sql)->setParameters(['codProducto' => $codProducto, 'fecha' => $fecha.'%'])->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }

    }
}