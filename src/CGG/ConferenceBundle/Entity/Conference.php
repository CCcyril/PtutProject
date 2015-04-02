<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Conference
{
    protected $id;
    protected $name;
    protected $creationDate;
    protected $startDate;
    protected $endDate;

    function __construct()
    {
        $this->creationDate = \date('r');
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }


    public function getStartDate()
    {
        return $this->startDate;
    }


    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }
}
