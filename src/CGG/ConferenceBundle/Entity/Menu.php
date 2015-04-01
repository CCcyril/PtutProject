<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 */
class Menu
{
    private $id;
    private $title;
    private $menuItem;

    public function __construct(){
        $this->menuItem = new ArrayCollection();
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

    public function addMenuItem(MenuItem $menuItem){
        $this->menuItem[] = $menuItem;
        $menuItem->setMenu($this);
        return $this;
    }

    public function removeMenuItem(MenuItem $menuitem){
        $this->menuItem->removeElement($menuitem);
    }

    public function getMenuItem(){
        return $this->menuItem;
    }
}
