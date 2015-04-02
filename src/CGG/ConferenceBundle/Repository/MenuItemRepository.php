<?php

namespace CGG\ConferenceBundle\Repository;

use CGG\ConferenceBundle\Entity\MenuItem;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class MenuItemRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }

    public function findByMenuId($idMenu){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('mi')
            ->where('mi.menuItem_menu = ' . $idMenu)
            ->getQuery();
        return $query->getResult();
    }

    public function save(MenuItem $menuItem){
        $this->entityManager->persist($menuItem);
        $this->entityManager->flush();
    }
}
