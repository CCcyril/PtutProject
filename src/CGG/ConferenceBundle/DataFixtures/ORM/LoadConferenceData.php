<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 12:11
 */
namespace CGG\ConferenceBundle\DataFixtures\ORM;

use CGG\ConferenceBundle\Entity\Content;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Page;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\Menu;
use CGG\ConferenceBundle\Entity\HeadBand;

class LoadConference implements FixtureInterface {

    public function load(ObjectManager $manager)
    {
        for($i = 0; $i <3; $i++){

            $menu = new Menu();
            $headBand = new HeadBand();
            $footer = new Footer();
            $page = new Page();
            $conference = new Conference();
            $content1 = new Content();
            $content2 = new Content();

            $menu->setTitle('Menu'.$i);
            $headBand->setTitle('Title'.$i);
            $headBand->setText('Text'.$i);
            $headBand->setImage('Image'.$i);
            $footer->setText('Footer'.$i);
            $content1->setText('Content'.$i);
            $content2->setText('Content'.($i+1));

            $page->setTitle('Home');
            $page->setPageFooter($footer);
            $page->setPageMenu($menu);
            $page->setPageHeadBand($headBand);
            $page->addContent($content1);
            $page->addContent($content2);

            $conference->setName("Conférence".$i);
            $conference->setStartDate(\date('r'));
            $conference->setEndDate("09/09/2020");
            $conference->addPageId($page);

            $manager->persist($conference);

        }
        $manager->flush();

    }
}