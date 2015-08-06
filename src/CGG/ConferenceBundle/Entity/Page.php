<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\Menu;
use CGG\ConferenceBundle\Entity\HeadBand;

class Page
{
    private $id;
    private $title;
    private $isHome;
    private $page_conference_id;
    private $contents;
    private $isContact;
    private $isLegal = "0";

    function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->isContact = 0;
    }

    public function getIsLegal()
    {
        return $this->isLegal;
    }

    public function setIsLegal($isLegal)
    {
        $this->isLegal = $isLegal;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function isHome(){
        return $this->isHome;
    }

    public function setHome($isHome){
        $this->isHome = $isHome;
    }

    public function setPageConferenceId(Conference $pageConferenceId = null)
    {
        $this->page_conference_id = $pageConferenceId;

        return $this;
    }

    public function getPageConferenceId()
    {
        return $this->page_conference_id;
    }

    public function addContent(Content $content)
    {
        $this->contents[] = $content;
        $content->setPage($this);
        return $this;
    }

    public function removeContent(Content $content)
    {
        $this->contents->removeElement($content);
    }

    public function getContents()
    {
        return $this->contents;
    }
    public function getContact()
    {
        return $this->isContact;
    }
    public function setContact($isContact)
    {
        $this->isContact = $isContact;
    }

}
