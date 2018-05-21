<?php

namespace App\Repository;

use App\Entity\Donacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Donacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donacion[]    findAll()
 * @method Donacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Donacion::class);
    }

//    /**
//     * @return Donacion[] Returns an array of Donacion objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Donacion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
