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
        $headBand = new HeadBand();
        $menu = new Menu();
        $footer = new Footer();

        $headBand->setTitle($conference->getName());
        $headBand->setText($conference->getDescription());
        $headBand->setImage('unJour');

        $menu->setTitle('wtf');

        $footer->setText('CGG Comférence © 2015 - <a href="#">Mentions légales</a> - <a href="#">Plan du site</a>');

        $homePage = $this->createDefaultHomePage($menu);
        $presentationPage = $this->createDefaultPresentationPage($menu);
        $informationPage = $this->createDefaultInformationPage($menu);
        $contactPage = $this->createDefaultContactPage($menu);

        $conference->setHeadband($headBand);
        $conference->setMenu($menu);
        $conference->setFooter($footer);
        $conference->addPageId($homePage);
        $conference->addPageId($presentationPage);
        $conference->addPageId($informationPage);
        $conference->addPageId($contactPage);

        return $conference;
    }

    public function createDefaultHomePage(Menu $menu){
        $homePage = new Page();
        $menuItem = new MenuItem($homePage);
        $content = new Content();

        $homePage->setIsHome('1');
        $homePage->setTitle('Accueil');

        $menuItem->setTitle($homePage->getTitle());
        $menuItem->setDepth('1');

        $menu->addMenuItem($menuItem);

        $content->setText('"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                            sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui
                            dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
                            incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
                            autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel
                            illum qui dolorem eum fugiat quo voluptas nulla pariatur?"');

        $homePage->addContent($content);

        return $homePage;
    }

    public function createDefaultPresentationPage(Menu $menu){
        $presentationPage = new Page();
        $menuItem = new MenuItem($presentationPage);
        $content = new Content();

        $presentationPage->setIsHome('0');
        $presentationPage->setTitle('Présentation');

        $menuItem->setTitle($presentationPage->getTitle());
        $menuItem->setDepth('2');

        $menu->addMenuItem($menuItem);

        $content->setText('"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                            sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui
                            dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
                            incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
                            autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel
                            illum qui dolorem eum fugiat quo voluptas nulla pariatur?"');

        $presentationPage->addContent($content);

        return $presentationPage;
    }

    public function createDefaultInformationPage(Menu $menu){
        $informationPage = new Page();
        $menuItem = new MenuItem($informationPage);
        $content = new Content();

        $informationPage->setIsHome('0');
        $informationPage->setTitle('Informations');

        $menuItem->setTitle($informationPage->getTitle());
        $menuItem->setDepth('3');

        $menu->addMenuItem($menuItem);

        $content->setText('"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                            sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui
                            dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
                            incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
                            autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel
                            illum qui dolorem eum fugiat quo voluptas nulla pariatur?"');

        $informationPage->addContent($content);

        return $informationPage;
    }

    public function createDefaultContactPage(Menu $menu){
        $contactPage = new Page();
        $menuItem = new MenuItem($contactPage);
        $content = new Content();

        $contactPage->setIsHome('0');
        $contactPage->setTitle('Contact');

        $menuItem->setTitle($contactPage->getTitle());
        $menuItem->setDepth('4');

        $menu->addMenuItem($menuItem);

        $content->setText('"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                            sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui
                            dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora
                            incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum
                            exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
                            autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel
                            illum qui dolorem eum fugiat quo voluptas nulla pariatur?"');

        $contactPage->addContent($content);

        return $contactPage;
    }
}