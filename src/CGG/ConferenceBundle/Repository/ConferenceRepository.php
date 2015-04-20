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

    public function findAllValid(){
       return $this->entityManager->getRepository('CGGConferenceBundle:Conference')->findBy(
           array('status' => 'V')
       );
    }
    public function findAllProgress(){
        return $this->entityManager->getRepository('CGGConferenceBundle:Conference')->findBy(
            array('status' => 'P')
        );
    }

    public function find($idConference){
        return $this->entityManager->find("CGGConferenceBundle:Conference", $idConference);
    }
}
