<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use \Doctrine\ORM\QueryBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }


    /**
     * 
     * @return array de usuarios con el total de donaciones realizadas
     *
     */
    public function TopDonationUsers()
    {
        
        $qb = $this->createQueryBuilder('u')
        ->select('us.nombre', 'sum(d.cantidad) as total', 'us.img', 'us.sector', 'us.destacado')
        ->from('App\Entity\User', 'us')
        ->innerJoin('App\Entity\Donacion','d', 'us.id = d.usuario_id')
        ->groupBy('us.nombre','us.img', 'us.sector', 'us.destacado')
        ->orderBy('us.destacado')
        ->getQuery();
        
        return $qb->getResult();
    }
    
    public function findPremiumByChargeId($chargeId)
    {
      return $this
        ->createQueryBuilder('u')
        ->andWhere('u.premium = :premium')
        ->andWhere('u.chargeId = :chargeId')
        ->setParameters([
          'premium' => true,
          'chargeId' => $chargeId,
        ])
        ->getQuery()
        ->getOneOrNullResult();
    }
    

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
