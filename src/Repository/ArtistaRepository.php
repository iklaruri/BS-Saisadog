<?php


namespace App\Repository;


use App\Entity\Artista;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArtistaRepository extends ServiceEntityRepository
{

    private $entityManager;

    /**
     * ArtistaRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artista::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function findArtistasNovedades(): array
    {
        $sql = "SELECT art.id,art.nombre AS artista,art.foto,art.fechafundacion
                    FROM App\Entity\Artista art
                    ORDER BY art.id DESC";
        $query = $this->entityManager->createQuery($sql)->setMaxResults(6);
        return $query->execute();
    }
}