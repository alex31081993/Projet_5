<?php

namespace App\Repository;

use App\Entity\AddPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AddPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddPost[]    findAll()
 * @method AddPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AddPost::class);
    }

//    /**
//     * @return AddPost[] Returns an array of AddPost objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AddPost
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
