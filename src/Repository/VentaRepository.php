<?php


namespace App\Repository;


use App\Entity\Venta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class VentaRepository extends ServiceEntityRepository
{
    private $entityManager;

    /**
     * VentaRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venta::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findLast()
    {
        $sql = "SELECT ven
                    FROM App\Entity\Venta ven            
                    ORDER BY ven.id DESC";
        $query = $this->entityManager->createQuery($sql)->setMaxResults(1);
        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}