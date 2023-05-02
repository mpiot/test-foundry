<?php

namespace App\Repository;

use App\Entity\ChangeRequestDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChangeRequestDocument>
 *
 * @method ChangeRequestDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChangeRequestDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChangeRequestDocument[]    findAll()
 * @method ChangeRequestDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChangeRequestDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChangeRequestDocument::class);
    }

    public function save(ChangeRequestDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChangeRequestDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
