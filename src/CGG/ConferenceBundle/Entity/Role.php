<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 22/04/15
 * Time: 16:18
 */

namespace CGG\ConferenceBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Role\RoleInterface;

class Role implements RoleInterface{

    protected $id;
    protected $name;
    protected $role;
    protected $users;

    /*TODO : check gestion des rôles : actuellement new Role(nomDuRole) user->setRole(Role role)*/
    public function __construct($name, $role){
        $this->setName($name);
        $this->setRole($role);
        $this->users = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
        return $this;
    }

    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    public function getUsers()
    {
        return $this->users;
    }
}