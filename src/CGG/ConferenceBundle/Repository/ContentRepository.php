<?php

namespace CGG\ConferenceBundle\Repository;

use CGG\ConferenceBundle\Entity\Content;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ContentRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function findByPageId($idPage){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:Content')->createQueryBuilder('c')
            ->where('c.page = ' . $idPage)
            ->getQuery();
        return $query->getResult();
    }

    public function find($idContent){
        return $this->entityManager->find("CGGConferenceBundle:Content", $idContent);
    }

    public function save(Content $content){
        $this->entityManager->persist($content);
        $this->entityManager->flush();
    }
}
