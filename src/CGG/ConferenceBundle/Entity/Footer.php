<?php

namespace CGG\ConferenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Footer
 */
class Footer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Footer
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
}
