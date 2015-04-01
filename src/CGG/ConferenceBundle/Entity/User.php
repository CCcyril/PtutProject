<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{

    private $id;
    private $lname;
    private $fname;
    private $email;
    private $password;
    private $address;
    private $country;
    private $zipcode;
    private $status;
    private $phone;
    private $inscriptionDate;

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

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
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
}
