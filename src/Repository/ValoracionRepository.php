<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Valoracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Valoracion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Valoracion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Valoracion[]    findAll()
 * @method Valoracion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValoracionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Valoracion::class);
    }

    public function getValoracionDelUsuario(User $user, Project $proyecto) {
        $result = $this->createQueryBuilder('v')
                        ->where('v.usuario = :usuario AND v.proyecto = :proyecto')
                        ->setParameter('usuario', $user)
                        ->setParameter('proyecto', $proyecto)
                        ->getQuery()
                        ->getResult();

        if(isset($result) && !empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

//    /**
//     * @return Valoracion[] Returns an array of Valoracion objects
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
    public function findOneBySomeField($value): ?Valoracion
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
