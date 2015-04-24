<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use CGG\ConferenceBundle\Entity\Page;

class Conference
{

    private $id;
    private $name;
    private $description;
    private $creationDate;
    private $startDate;
    private $endDate;
    private $pages;
    private $status;

    function __construct()
    {
        $this->creationDate = \date('r');
        $this->pages = new ArrayCollection();
        $this->setStatus('P');
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

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
       $this->description = $description;
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

    public function addPageId(Page $page)
    {
        $this->pages[] = $page;
        $page->setPageConferenceId($this);
        return $this;
    }

    public function removePageId(Page $page)
    {
        $this->pages->removeElement($page);
    }

    public function getPageId()
    {
        return $this->pages;
    }

    public function getHomePage() {
        foreach ($this->pages as $page) {
            if ($page->getIsHome() === '1') {
                return $page;
            }
        }
        return null;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
