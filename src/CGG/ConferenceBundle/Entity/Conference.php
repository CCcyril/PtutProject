<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Conference
{

    private $id;
    private $name;
    private $description;
    private $creationDate;
    private $startDate;
    private $endDate;
    private $pages;
    private $headband;
    private $menu;
    private $footer;
    private $status;
    private $mainColor;
    private $secondaryColor;
    private $emailContact;
    private $imagePath;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    function __construct()
    {
        $this->creationDate = \date('r');
        $this->pages = new ArrayCollection();
        $this->setStatus('P');
        $this->mainColor = "#2B1138";
        $this->secondaryColor = "#E84349";
        $this->emailContact = null;
        $this->imagePath = null;
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
            if ($page->isHome() === '1') {
                return $page;
            }
        }
        return null;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getHeadband(){
        return $this->headband;
    }

    public function setHeadband(HeadBand $headband){
        $this->headband = $headband;
    }

    public function getMenu(){
        return $this->menu;
    }

    public function setMenu(Menu $menu){
        $this->menu = $menu;
    }

    public function getFooter(){
        return $this->footer;
    }

    public function setFooter(Footer $footer){
        $this->footer = $footer;
    }
    public function getMainColor()
    {
        return $this->mainColor;
    }
    public function setMainColor($mainColor)
    {
        $this->mainColor = $mainColor;
    }
    public function getSecondaryColor()
    {
        return $this->secondaryColor;
    }
    public function setSecondaryColor($secondaryColor)
    {
        $this->secondaryColor = $secondaryColor;
    }
    public function getEmailContact()
    {
        return $this->emailContact;
    }
    public function setEmailContact($emailContact)
    {
        $this->emailContact = $emailContact;
    }
    public function getImagePath()
    {
        return $this->imagePath;
    }
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }
    public function getAbsolutePath()
    {
        return null === $this->imagePath ? null : $this->getUploadRootDir().'/'.$this->imagePath;
    }

    public function getWebPath()
    {
        return null === $this->imagePath ? null : $this->getUploadDir().'/'.$this->imagePath;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/uploads/logos';
    }
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->imagePath = $this->file->getClientOriginalName();
    }

    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
}
