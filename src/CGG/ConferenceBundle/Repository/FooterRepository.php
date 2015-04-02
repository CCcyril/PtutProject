<?php

namespace CGG\ConferenceBundle\Repository;

use CGG\ConferenceBundle\Entity\Footer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class FooterRepository extends EntityRepository
{
    protected $entityManger;

    public function __construct(EntityManager $entityManager){
        $this->entityManger = $entityManager;
    }

    public function save(Footer $footer){
        $this->entityManger->persist($footer);
        $this->entityManger->flush();
    }
}
