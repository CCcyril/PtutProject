<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 12:11
 */
namespace CGG\ConferenceBundle\DataFixtures\ORM;

use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\MenuItem;
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

            $conference = new Conference();
            $page = new Page();
            $menu = new Menu();
            $menuItem = new MenuItem($page);
            $headBand = new HeadBand();
            $footer = new Footer();
            $content1 = new Content();
            $content2 = new Content();

            $menuItem->setDepth($i);
            $menuItem->setTitle('menuItem'.$i);
            $menu->setTitle('Menu'.$i);
            $menu->addMenuItem($menuItem);
            $headBand->setTitle('Title'.$i);
            $headBand->setText('Text'.$i);
            $headBand->setImage('Image'.$i);
            $footer->setText('Footer'.$i);
            $content1->setText('Content'.$i);
            $content2->setText('Content'.($i+1));

            $page->setTitle('Home');
            $page->setHome('1');
            $page->addContent($content1);
            $page->addContent($content2);

            $conference->setName("Conférence".$i);
            $conference->setDescription('Descritpion'.$i);
            $conference->setStartDate(\date('r'));
            $conference->setEndDate("09/09/2020");
            $conference->addPageId($page);
            $conference->setStatus("V");
            $conference->setFooter($footer);
            $conference->setMenu($menu);
            $conference->setHeadBand($headBand);
            $conference->setEmailContact("mathisghomari@hotmail.fr");

            $manager->persist($conference);

        }
        $manager->flush();

    }
}