<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }

    public function findAllByTagLetter()
    {
        $tags = $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();

        $tags_by_letter = array();

        // Sort tags by letter
        foreach ($tags as $tag) {
            $first_letter = substr($tag->getName(), 0, 1);

            // Create array for letter if it doesn’t exist
            if (!isset($tags_by_letter[$first_letter])) {
                $tags_by_letter[$first_letter] = array();
            }

            $tags_by_letter[$first_letter][] = $tag;
        }

        return $context['tags_by_letter'] = $tags_by_letter;
    }

    public function getThemesCounts()
    {
        return $this->createQueryBuilder('c')
            ->select('c.name, COUNT(c.id) AS counter')
            ->innerJoin('c.themes', 't')
            ->groupBy('c')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Tag[] Returns an array of Tag objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tag
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
