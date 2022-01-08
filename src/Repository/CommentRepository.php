<?php

namespace App\Repository;

use App\Entity\Theme;
use App\Entity\Comment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 6;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findRecentPublishedComments()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.state = :state')
            ->setParameter('state', 'published')
            ->setMaxResults(20)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllPublishedCommentsByTheme(Theme $theme)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.theme = :theme')
            ->andWhere('t.state = :state')
            ->setParameter('theme', $theme)
            ->setParameter('state', 'published')
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getCommentPaginator(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.state = :state')
            ->setParameter('state', 'published')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getCommentPaginatorByTheme(Theme $theme, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->andWhere('t.theme = :theme')
            ->andWhere('t.state = :state')
            ->setParameter('theme', $theme)
            ->setParameter('state', 'published')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    public function getCommentLastDays()
    {
        $stmt  = $this->getEntityManager()->getConnection()->prepare('SELECT COUNT(id) num, DATE(created_at) d FROM comment GROUP BY DATE(created_at)');
        $result = $stmt->executeQuery()->fetchAllAssociative();

        return $result;
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
