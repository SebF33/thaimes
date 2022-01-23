<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public const MAX_RECENT_PARTICIPATIONS = 80;

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

    public function findRecentComments()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.state = :state')
            ->setParameter('state', 'published')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(self::MAX_RECENT_PARTICIPATIONS)
            ->getQuery()
            ->getResult();
    }

    public function findCommentsByTheme(Theme $theme)
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

    public function findCommentsByQuery(string $query)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->like('unaccent(LOWER(c.text))', 'unaccent(LOWER(:query))'),
                    $qb->expr()->like('c.state', ':state')
                )
            )
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('state', 'published')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function getCommentLastDays()
    {
        $sql = 'SELECT COUNT(id) num, DATE(created_at) d FROM comment GROUP BY DATE(created_at)';
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        return $result;
    }

    public function getNumPendingReview()
    {
        $states = ['ham', 'potential_spam', 'submitted'];

        return $this->createQueryBuilder('t')
            ->select('count(t.id)')
            ->where('t.state IN (:states)')
            ->setParameter('states', $states)
            ->getQuery()
            ->getSingleScalarResult();
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
