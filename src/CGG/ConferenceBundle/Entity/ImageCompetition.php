<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 02:05
 */

namespace CGG\ConferenceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class ImageCompetition {
    private $id;
    private $description;
    private $path;
    private $title;
    private $rating;
    private $conference_id;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getConferenceId()
    {
        return $this->conference_id;
    }


    public function setConferenceId($conference_id)
    {
        $this->conference_id = $conference_id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }



    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/uploads';
    }
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        $this->path = $this->file->getClientOriginalName();
    }
}