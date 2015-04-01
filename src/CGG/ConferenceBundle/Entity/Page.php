<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\Menu;
use CGG\ConferenceBundle\Entity\HeadBand;

/**
 * Page
 */
class Page
{

    private $id;
    private $title;
    private $page_conference_id;
    private $page_menu;
    private $page_headBand;
    private $page_footer;
    private $contents;

    function __construct()
    {
        $this->contents = new ArrayCollection();
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

    public function setPageConferenceId(Conference $pageConferenceId = null)
    {
        $this->page_conference_id = $pageConferenceId;

        return $this;
    }

    public function getPageConferenceId()
    {
        return $this->page_conference_id;
    }

    public function setPageMenu(Menu $pageMenu = null)
    {
        $this->page_menu = $pageMenu;

        return $this;
    }

    public function getPageMenu()
    {
        return $this->page_menu;
    }

    public function setPageHeadBand(HeadBand $pageHeadBand = null)
    {
        $this->page_headBand = $pageHeadBand;

        return $this;
    }

    public function getPageHeadBand()
    {
        return $this->page_headBand;
    }

    public function setPageFooter(Footer $pageFooter = null)
    {
        $this->page_footer = $pageFooter;

        return $this;
    }

    public function getPageFooter()
    {
        return $this->page_footer;
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
}
