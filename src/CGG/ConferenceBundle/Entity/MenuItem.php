<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class MenuItem
{

    private $id;
    private $title;
    private $depth;
    private $menuItem_menu;
    private $idMenuItemParent = NULL;
    private $page;

    public function __construct(Page $page){
        $this->setPage($page);
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

    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function getMenu(){
        return $this->menuItem_menu;
    }

    public function setMenu(Menu $menu){
        $this->menuItem_menu = $menu;
    }

    public function isParent(){
        return $this->idMenuItemParent;
    }

    public function setParent($idMenuItem){
        $this->idMenuItemParent = $idMenuItem;
    }

    public function getPage(){
        return $this->page;
    }

    public function setPage(Page $page){
        $this->page = $page;
    }

}
