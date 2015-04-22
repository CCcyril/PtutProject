<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 22/04/15
 * Time: 16:18
 */

namespace CGG\ConferenceBundle\Entity;


use Symfony\Component\Security\Core\Role\RoleInterface;

class Role implements RoleInterface{

    protected $id;
    protected $role;
    /*TODO : check gestion des rôles : actuellement new Role(nomDuRole) user->setRole(Role role)*/
    public function __construct($role){
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }
}