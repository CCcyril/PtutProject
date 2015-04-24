<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 24/04/15
 * Time: 11:52
 */

namespace CGG\ConferenceBundle\Controller;


use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\HeadBand;
use CGG\ConferenceBundle\Entity\Menu;
use CGG\ConferenceBundle\Entity\MenuItem;
use CGG\ConferenceBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultConferenceController extends Controller {

    public function defaultConferenceAction(Conference $conference){
        $menu = new Menu();
        $menuItem = new MenuItem();
        $menuItem2 = new MenuItem();
        $headBand = new HeadBand();
        $footer = new Footer();
        $page = new Page();
        $content1 = new Content();
        $content2 = new Content();

        $menuItem->setDepth(1);
        $menuItem->setTitle('menuItem4');
        $menuItem2->setDepth(2);
        $menuItem2->setTitle('menuItem5');
        $menu->setTitle('Menu4');
        $menu->addMenuItem($menuItem);
        $menu->addMenuItem($menuItem2);
        $headBand->setTitle('Title4');
        $headBand->setText('Text4');
        $headBand->setImage('Image4');
        $footer->setText('Footer4');
        $content1->setText('Content4');
        $content2->setText('Content5');

        $page->setTitle('Home');
        $page->setIsHome('1');
        $page->setPageFooter($footer);
        $page->setPageMenu($menu);
        $page->setPageHeadBand($headBand);
        $page->addContent($content1);
        $page->addContent($content2);
        $page->setPageMenu($menu);

        $conference->setName("Conférence4");
        $conference->setDescription('Descritpion4');
        $conference->setStartDate(\date('r'));
        $conference->setEndDate("09/09/2020");
        $conference->addPageId($page);
        $conference->setStatus("V");

        return $conference;
    }
}