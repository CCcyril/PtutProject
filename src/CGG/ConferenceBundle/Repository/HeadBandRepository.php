<?php

namespace CGG\ConferenceBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\CGG\ConferenceBundle\Entity\HeadBand;

class HeadBandRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function save(HeadBand $headBand){
        $this->entityManager->persist($headBand);
        $this->entityManager->flush();
    }
}
