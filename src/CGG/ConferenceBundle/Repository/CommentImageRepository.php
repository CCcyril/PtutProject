<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 13/05/15
 * Time: 00:46
 */

namespace CGG\ConferenceBundle\Repository;


use CGG\ConferenceBundle\Entity\CommentImage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class CommentImageRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByIdImage($idImage){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:CommentImage')->createQueryBuilder('c')
            ->where('c.image_id = :idImage')
            ->setParameter('idImage', $idImage)
            ->getQuery();
        return $query->getResult();
    }
    public function save(CommentImage $comment){
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}