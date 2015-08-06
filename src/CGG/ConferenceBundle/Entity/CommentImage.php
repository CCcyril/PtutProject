<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 18:21
 */

namespace CGG\ConferenceBundle\Entity;


class CommentImage {
    private $id;
    private $comment;
    private $image_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    public function getImageId()
    {
        return $this->image_id;
    }
    public function setImageId($image_id)
    {
        $this->image_id = $image_id;
    }
}