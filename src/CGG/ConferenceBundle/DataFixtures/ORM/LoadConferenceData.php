<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 12:11
 */
namespace CGG\ConferenceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CGG\ConferenceBundle\Entity\Conference;

class LoadConference implements FixtureInterface {

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i <3; $i++){
            $conference = new Conference();
            $conference->setName("Conférence".$i);
            $conference->setStartDate(\date('r'));
            $conference->setEndDate("09/09/2020");
            $manager->persist($conference);
        }
        $manager->flush();

    }
}