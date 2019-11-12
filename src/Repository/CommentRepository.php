<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findAllWithUserQuery()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.reported = true')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
        ;
    }

    public function findAllReportedCommentQuery()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.reported = false')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
        ;
    }

    // public function findOneReportedComment($id)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.reported = false')
    //         ->andWhere('c.user = :userId')
    //         ->setParameter('userId', $id)
    //         ->getQuery()
    //         ->getSingleScalarResult()
    //     ;
    // }

    public function countAllComment()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function lastCommentFromAll()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.reported = true')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    //------------------------------------------------------------
    
    public function countAllCommentsOfUser($userId)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.user)')
            ->andWhere('c.reported = true')
            ->andWhere('c.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function countAllReportedOfUser($reportedUserId)
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.user)')
            ->andWhere('c.reported = false')
            ->andWhere('c.user = :reportedUserId')
            ->setParameter('reportedUserId', $reportedUserId)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

  

    
    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
