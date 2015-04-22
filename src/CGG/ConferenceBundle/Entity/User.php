<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{

    protected $id;
    protected $lname;
    protected $fname;
    protected $username;
    protected $email;
    protected $salt;
    protected $password;
    protected $address;
    protected $country;
    protected $zipcode;
    protected $status;
    protected $phone;
    protected $inscriptionDate;
    protected $role;

    public function __construct(){
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    public function getLname()
    {
        return $this->lname;
    }

    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    public function getFname()
    {
        return $this->fname;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){
        $this->username = $username;
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

    public function getSalt(){
        return $this->salt;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
       $this->password = $password;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function setRoles(Role $role){
        $this->role = $role;
    }

    public function eraseCredentials()
    {
    }
}
