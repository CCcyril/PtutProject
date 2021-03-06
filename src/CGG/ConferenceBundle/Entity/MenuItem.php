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
    private $children;

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

    public function getParent(){
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

    public function addChildren(MenuItem $menuItem)
    {
        $this->children[] = $menuItem;
        return $this;
    }

    public function removeChildren(MenuItem $menuItem)
    {
        $this->contents->removeElement($menuItem);
    }

    public function getChildren(){
        return $this->children;
    }

}
