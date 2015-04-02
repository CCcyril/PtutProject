<?php

namespace CGG\ConferenceBundle\Repository;

use CGG\ConferenceBundle\Entity\Conference;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ConferenceRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function findAllConferenceByStatus($status){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:Conference')->createQueryBuilder('c')
            ->where('c.status = :status')
            ->setParameter('status', $status)
            ->getQuery();
        return $query->getResult();
    }

    public function find($idConference){
        return $this->entityManager->find("CGGConferenceBundle:Conference", $idConference);
    }

    public function save(Conference $conference){
        $this->entityManager->persist($conference);
        $this->entityManager->flush();
    }
}
