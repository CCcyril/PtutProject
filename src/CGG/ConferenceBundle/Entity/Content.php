<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Content
{

    private $id;
    private $text;
    private $page;


    public function getId()
    {
        return $this->id;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(Page $page = null)
    {
        $this->page = $page;

        return $this;
    }
}
