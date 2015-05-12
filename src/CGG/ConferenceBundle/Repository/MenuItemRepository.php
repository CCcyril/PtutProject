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

    public function findByMenuIdOrderByDepth($idMenu){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('mi')
            ->where('mi.menuItem_menu = ' . $idMenu)
            ->addOrderBy('mi.depth')
            ->getQuery();
        return $query->getResult();
    }

    public function save(MenuItem $menuItem){
        $this->entityManager->persist($menuItem);
        $this->entityManager->flush();
    }

    public function countMenuItemDepth($menuId){
        $depth = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('mi')
            ->select('COUNT(mi.depth) as nbDepth')
            ->where('mi.menuItem_menu = :menuId')
            ->setParameter('menuId', $menuId)
            ->getQuery()
            ->getSingleResult();

        return $depth['nbDepth'];
    }
}
