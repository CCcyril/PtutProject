<?php

namespace CGG\ConferenceBundle\Entity;


class ConferenceUser {

    private $id;
    private $isAdmin;
    private $isJury;
    private $user;
    private $conference;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    public function getIsJury()
    {
        return $this->isJury;
    }

    public function setIsJury($isJury)
    {
        $this->isJury = $isJury;
    }

    public function getConference()
    {
        return $this->conference;
    }

    public function setConference(Conference $conference)
    {
        $this->conference = $conference;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}