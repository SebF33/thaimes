<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 4;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    public function getThemePaginator(int $offset): Paginator
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.display = :val')
            ->setParameter('val', TRUE)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($qb);
    }

    public function findAll()
    {
        return $this->findBy([], ['createdAt' => 'DESC']);
    }

    public function findAllDisplayThemes()
    {
        return $this->createQueryBuilder('t')
            ->where('t.display = :val')
            ->setParameter('val', TRUE)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findThemesByTitle(string $query)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->like('LOWER(t.title)', 'LOWER(:query)'),
                    $qb->expr()->isNotNull('t.createdAt')
                )
            )
            ->andWhere($qb->expr()->eq('t.display', ':val'))
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('val', TRUE)
            ->getQuery()
            ->getResult();

        return $qb;
    }

    /*
    public function findOneBySomeField($value): ?Theme
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
