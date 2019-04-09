<?php

namespace App\Repository;

use App\Entity\GameScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameScore[]    findAll()
 * @method GameScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameScore::class);
    }

    /**
     * @return GameScore[] Returns an array of GameScore objects
     */
    public function findLastestScores($user, $game)
    {
        return $this->createQueryBuilder('q')
        
        ->add('select', 'gs')
        ->add('from', 'App\Entity\GameScore gs')
        ->add('orderBy', 'gs.createdAt DESC')        
        ->where('gs.user = :user')
        ->andWhere('gs.game = :game')
        ->setParameters(['user' => $user, 'game' => $game])
        ->setMaxResults(3)
        ->getQuery()
        ->getResult()
        ;
    }


    /**
     * @return GameScore[] Returns an array of GameScore objects
     */
    public function findBestGameScores($game)
    {
        return $this->createQueryBuilder('q')
        
        ->add('select', 'gs')
        ->add('from', 'App\Entity\GameScore gs')
        ->add('orderBy', 'gs.score DESC')        
        ->where('gs.game = :game')
        ->setParameter('game', $game)
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
        ;
    }
    // /**
    //  * @return GameScore[] Returns an array of GameScore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameScore
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
