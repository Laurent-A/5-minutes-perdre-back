<?php

namespace App\Repository;

use App\Entity\Wiki;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Wiki|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wiki|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wiki[]    findAll()
 * @method Wiki[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WikiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wiki::class);
    }

    public function findAllCustom(){

        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT wiki.id, wiki.name, wiki.body, wiki.createdAt as created, wiki.source, wiki.image, t.name as tag
             FROM App\Entity\Wiki wiki JOIN wiki.tags t WHERE wiki.online = true 
            '
        );

        return $query->execute();
        
    }
    // /**
    //  * @return Wiki[] Returns an array of Wiki objects
    //  */
    /*
    public function online($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.online = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wiki
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
