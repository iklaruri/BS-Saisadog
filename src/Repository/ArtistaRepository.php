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

    public function findAllOrder(): array
    {
        $sql = "SELECT art
                    FROM App\Entity\Artista art
                    ORDER BY art.nombre";
        $query = $this->entityManager->createQuery($sql);
        return $query->execute();
    }

    public function findByTermino($termino): array
    {
        $sql = "SELECT art
                    FROM App\Entity\Artista art
                    WHERE art.nombre LIKE :termino";
        $query = $this->entityManager->createQuery($sql)->setParameter('termino', '%'.$termino.'%');
        return $query->execute();
    }


}
