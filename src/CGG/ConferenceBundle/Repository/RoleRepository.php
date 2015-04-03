<?php

namespace CGG\ConferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
{
    public function findRoleByName($name){
        $role = $this->createQueryBuilder('r')
            ->where('r.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();

        return $role;
    }

    public function listRoles(){
        return $this->createQueryBuilder('r')->getQuery()->getResult();
    }
}