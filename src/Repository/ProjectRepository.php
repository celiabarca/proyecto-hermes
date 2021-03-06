<?php

namespace App\Repository;

use App\Entity\Donacion;
use App\Entity\Project;
use App\Entity\Valoracion;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\Tag;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * Devuelve los proyectos mas valorados o menos valorados
     * @param string $orden
     * @return mixed
     */
    public function findByValoracion(string $orden) {
        return $this->createQueryBuilder('project')
                    ->select('project')
                    ->innerJoin(Valoracion::class, 'valoracion')
                    ->where('valoracion.megusta = true')
                    ->groupBy('project')
                    ->orderBy('COUNT(valoracion.megusta)', strtoupper($orden))
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Devuelve los proyectos mas donados o menos donados
     * @param string $orden
     * @return mixed
     */
    public function findByDonaciones(string $orden) {
        return $this->createQueryBuilder('project')
                    ->select('project')
                    ->leftJoin('project.donaciones', 'donacion')
                    ->groupBy('project')
                    ->orderBy('SUM(donacion.cantidad)', $orden)
                    ->getQuery()
                    ->getResult();
    }
    
    public function findByName(string $name)
    {
        return $this->createQueryBuilder('project')
                    ->select('project')
                    ->innerJoin(Tag::class, 'tag')
                    ->where('project.titulo LIKE :name OR tag.nombre like :name')
                    ->setParameter('name', '%'.$name.'%')
                    ->getQuery()
                    ->getResult();
    }
   
//    /**
//     * @return Project[] Returns an array of Project objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
