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

    public function save(Conference $conference){
        $this->entityManager->persist($conference);
        $this->entityManager->flush();
    }

    public function findAll(){
        return $this->entityManager->getRepository('CGGConferenceBundle:Conference')->findAll();
    }
}
