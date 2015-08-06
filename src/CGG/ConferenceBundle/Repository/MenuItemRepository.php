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

    public function find($idMenuItem){
        return $this->entityManager->find('CGGConferenceBundle:MenuItem', $idMenuItem);
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

    public function removeMenuItem(MenuItem $menuItem){
        $this->entityManager->remove($menuItem);
        $this->entityManager->flush();
    }

    public function findPageLinkMenuItem($idPage){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('m')
            ->where('m.page = :idPage')
            ->setParameter('idPage', $idPage)
            ->getQuery();

        return $query->getResult()[0];
    }

    public function findMenuItemWithoutParentOrderedByDepth($idMenu){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('mi')
            ->where('mi.idMenuItemParent IS NULL')
            ->andWhere('mi.menuItem_menu = :idMenu')
            ->setParameter('idMenu', $idMenu)
            ->addOrderBy('mi.depth')
            ->getQuery();

        return $query->getResult();
    }

    public function findMenuItemChildren($idMenuItem, $idMenu){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:MenuItem')->createQueryBuilder('mi')
            ->where('mi.idMenuItemParent = :idMenuItem')
            ->andWhere('mi.menuItem_menu = :idMenu')
            ->setParameter('idMenuItem', $idMenuItem)
            ->setParameter('idMenu', $idMenu)
            ->addOrderBy('mi.depth')
            ->getQuery();

        return $query->getResult();
    }
}
