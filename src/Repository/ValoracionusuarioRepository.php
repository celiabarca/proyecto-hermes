<?php

namespace App\Repository;

use App\Entity\Valoracionusuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Valoracionusuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valoracionusuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valoracionusuario[]    findAll()
 * @method Valoracionusuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionusuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Valoracionusuario::class);
    }

//    /**
//     * @return Valoracionusuario[] Returns an array of Valoracionusuario objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Valoracionusuario
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
