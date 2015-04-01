<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\HeadBand;
use CGG\ConferenceBundle\Entity\MenuItem;
use CGG\ConferenceBundle\Form\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConferenceController extends Controller
{
    public function indexAction($name)
    {

        return $this->render('CGGConferenceBundle:Default:index.html.twig', array('name' => "mathis"));
    }

    public function homeAction() {

        return $this->render('CGGConferenceBundle:Conference:home.html.twig', array());
    }

    public function listAction() {
        $conferenceList = $this->get('conference_repository')->findAll();
        return $this->render('CGGConferenceBundle:Conference:list.html.twig', array("conferenceList"=>$conferenceList));
    }

    public function createConferenceAction(Request $request){
        $conference = new Conference();
        $form = $this->createForm(New ConferenceType(), $conference);

        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $this->get('conference_repository')->save($conference);
                return $this->render('CGGConferenceBundle:Conference:conferenceCreated.html.twig');
            }
        }

        return $this->render('CGGConferenceBundle:Conference:createConference.html.twig', ['form'=>$form->createView()]);
    }
    public function detailAction($idConference){

        $conference = $this->get('conference_repository')->find($idConference);

        $headBand = new HeadBand();

        $headBand->setTitle("Titre Header");
        $headBand->setText("Un header qui a un titre et un texte !");

        $menuItem1 = new MenuItem();
        $menuItem2 = new MenuItem();
        $menuItem3 = new MenuItem();

        $menuItem1->setTitle('Page 1');
        $menuItem2->setTitle('Page 2');
        $menuItem3->setTitle('Page 3');

        $menuItem1->setDepth(1);
        $menuItem2->setDepth(2);
        $menuItem3->setDepth(3);

        $menuItems = array($menuItem1, $menuItem2, $menuItem3);

        $content = new Content();

        $content->setText("Alors au début y avait un texte dans le content, du coup fallait que je l'écrive et j'avais la flemme du coup bah comme j'avais la flemme j'ai fait contrôle (comme le contrôleur mdr) + C puis CTRL + V mdr.
                           Alors au début y avait un texte dans le content, du coup fallait que je l'écrive et j'avais la flemme du coup bah comme j'avais la flemme j'ai fait contrôle (comme le contrôleur mdr) + C puis CTRL + V mdr.
                           Alors au début y avait un texte dans le content, du coup fallait que je l'écrive et j'avais la flemme du coup bah comme j'avais la flemme j'ai fait contrôle (comme le contrôleur mdr) + C puis CTRL + V mdr.");

        $footer = new Footer();

        $footer->setText("Ceci est le texte du footer!");

        if ($conference !== NULL) {
            return $this->render('::conferenceBase.html.twig', array(
                'conference' => $conference,
                'headband' => $headBand,
                'menuItems' => $menuItems,
                'content' => $content,
                'footer' => $footer
            ));
        } else {
            return $this->render('CGGConferenceBundle:Conference:conferenceNotFound.html.twig', array());
        }
    }
}
