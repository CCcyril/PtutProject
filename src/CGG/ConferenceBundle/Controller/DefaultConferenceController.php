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

        $homePage = $this->createDefaultHomePageAction($menu);
        $presentationPage = $this->createDefaultPresentationPageAction($menu);
        $informationPage = $this->createDefaultInformationPageAction($menu);
        $contactPage = $this->createDefaultContactPageAction($menu);
        $mentionsLegalesPage = $this->createDefaultMentionsLegalesPageAction($menu);

        $footer->setText('');

        $conference->setHeadband($headBand);
        $conference->setMenu($menu);
        $conference->setFooter($footer);
        $conference->addPageId($homePage);
        $conference->addPageId($presentationPage);
        $conference->addPageId($informationPage);
        $conference->addPageId($contactPage);
        $conference->addPageId($mentionsLegalesPage);

        return $conference;
    }

    public function createDefaultHomePageAction(Menu $menu){
        $homePage = new Page();
        $menuItem = new MenuItem($homePage);
        $content = new Content();

        $homePage->setHome('1');
        $homePage->setContact('0');
        $homePage->setTitle('Accueil');

        $menuItem->setTitle($homePage->getTitle());
        $menuItem->setDepth('1');

        $menu->addMenuItem($menuItem);

        $content->setText('"Contenu par défaut, vous pouvez le modifier ou en ajouter un nouveau."');

        $homePage->addContent($content);

        return $homePage;
    }

    public function createDefaultPresentationPageAction(Menu $menu){
        $presentationPage = new Page();
        $menuItem = new MenuItem($presentationPage);
        $content = new Content();

        $presentationPage->setHome('0');
        $presentationPage->setContact('0');
        $presentationPage->setTitle('Présentation');

        $menuItem->setTitle($presentationPage->getTitle());
        $menuItem->setDepth('2');

        $menu->addMenuItem($menuItem);

        $content->setText('Contenu par défaut, vous pouvez le modifier ou en ajouter un nouveau.');

        $presentationPage->addContent($content);

        return $presentationPage;
    }

    public function createDefaultInformationPageAction(Menu $menu){
        $informationPage = new Page();
        $menuItem = new MenuItem($informationPage);
        $content = new Content();

        $informationPage->setHome('0');
        $informationPage->setContact('0');
        $informationPage->setTitle('Informations');

        $menuItem->setTitle($informationPage->getTitle());
        $menuItem->setDepth('3');

        $menu->addMenuItem($menuItem);

        $content->setText('Contenu par défaut, vous pouvez le modifier ou en ajouter un nouveau.');

        $informationPage->addContent($content);

        return $informationPage;
    }

    public function createDefaultContactPageAction(Menu $menu){
        $contactPage = new Page();
        $menuItem = new MenuItem($contactPage);
        $content = new Content();

        $contactPage->setHome('0');
        $contactPage->setContact('1');
        $contactPage->setTitle('Contact');

        $menuItem->setTitle($contactPage->getTitle());
        $menuItem->setDepth('4');

        $menu->addMenuItem($menuItem);

        $content->setText('<div class="col-md-6">
            <div id="reponseContact"></div>
            <h2>Formulaire de contact</h2>
                <div class="form-group">
                    <label>Nom :</label>
                    <input type="text" id="name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Prénom :</label>
                    <input type="text" id="firstName" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Mail :</label>
                    <input type="email" id="email" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Sujet :</label>
                    <input type="text" id="sujet" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Message :</label>
                    <textarea id="message" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary" id="envoieEmail">Contact</button>
                </div>
        </div>
        <div class="col-md-6">
            <div id="map"></div>
        </div> ');

        $contactPage->addContent($content);

        return $contactPage;
    }
    public function createDefaultMentionsLegalesPageAction(Menu $menu){
        $mentionsLegalesPage = new Page();
        $menuItem = new MenuItem($mentionsLegalesPage);
        $content = new Content();

        $mentionsLegalesPage->setHome('0');
        $mentionsLegalesPage->setContact('0');
        $mentionsLegalesPage->setTitle('Mentions légales');
        $mentionsLegalesPage->setIsLegal('1');

        $content->setText('
        <h3>CGGConference</h3>
        <h4>Ce site internet a été réalisé par :</h4>
        <p>Les étudiants de la licence professionnelle METINET 2014/2015</p>
        <p>71 Rue Peter Fink, 01000 Bourg-en-Bresse</p>
        <p>04 74 45 50 50</p>
        <h4>Directeur de la publication : </h4>
        <p>IUT Lyon 1 Bourg en bresse</p>
        <h4>Hébergement</h4>
        ');

        $mentionsLegalesPage->addContent($content);

        return $mentionsLegalesPage;
    }
}