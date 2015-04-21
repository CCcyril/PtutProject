<?php

namespace CGG\ConferenceBundle\Repository;

use CGG\ConferenceBundle\Entity\Page;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function findByConferenceId($idConference){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:Page')->createQueryBuilder('p')
                ->where('p.page_conference_id = ' . $idConference)
                ->getQuery();
        return $query->getResult();
    }

    public function find($idPage){
        return $this->entityManager->find('CGGConferenceBundle:Page', $idPage);
    }

    public function save(Page $page){
        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }
}
