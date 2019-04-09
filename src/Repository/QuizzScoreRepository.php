<?php

namespace App\Repository;

use App\Entity\QuizzScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuizzScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizzScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizzScore[]    findAll()
 * @method QuizzScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizzScoreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuizzScore::class);
    }

    /**
     * @return QuizzScore[] Returns an array of GameScore objects
     */
    public function findLastestScores($user, $quizz)
    {
        return $this->createQueryBuilder('q')
        
        ->add('select', 'qs')
        ->add('from', 'App\Entity\QuizzScore qs')
        ->add('orderBy', 'qs.createdAt DESC')        
        ->where('qs.user = :user')
        ->andWhere('qs.quizz = :quizz')
        ->setParameters(['user' => $user, 'quizz' => $quizz])
        ->setMaxResults(3)
        ->getQuery()
        ->getResult()
        ;
    }

     /**
     * @return QuizzScore[] Returns an array of QuizzScore objects
     */
    public function findBestQuizzScores($quizz)
    {
        return $this->createQueryBuilder('q')
        
        ->add('select', 'qs')
        ->add('from', 'App\Entity\QuizzScore qs')
        ->add('orderBy', 'qs.score DESC')        
        ->where('qs.quizz = :quizz')
        ->setParameter('quizz', $quizz)
        ->setMaxResults(5)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findScoreByUser($user)
    {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT qs.score, quizz.title
             FROM App\Entity\QuizzScore qs JOIN qs.quizz as quizz WHERE qs.user = '.$user.' ORDER BY qs.createdAt DESC'
            
        )->setMaxResults(3);
        
        return $query->execute();
    }

    // /**
    //  * @return QuizzScore[] Returns an array of QuizzScore objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuizzScore
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
