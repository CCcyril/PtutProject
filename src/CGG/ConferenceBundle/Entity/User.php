<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 23/04/15
 * Time: 13:59
 */

namespace CGG\ConferenceBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{

    private $id;
    private $salt;
    private $username;
    private $plainPassword;
    private $password;
    private $email;
    private $isActive;
    private $roles;

    public function __construct()
    {
        $this->isActive = true;
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->roles = new ArrayCollection();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getPlainPassword(){
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword){
        $this->plainPassword = $plainPassword;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            ) = unserialize($serialized);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function isActive()
    {
        return $this->isActive;
    }


    public function isEnabled()
    {
        return $this->isActive;
    }

    public function addRole(Role $role){
        $this->roles[] = $role;
    }

    public function removeRole(Role $role){
        $this->roles->removeElement($role);
    }

    public function getRoles(){
        return $this->roles->toArray();
    }
}
