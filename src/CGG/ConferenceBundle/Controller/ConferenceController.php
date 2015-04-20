<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\HeadBand;
use CGG\ConferenceBundle\Entity\MenuItem;
use CGG\ConferenceBundle\Form\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ConferenceController extends Controller
{
    public function homeAction() {

        return $this->render('CGGConferenceBundle:Conference:home.html.twig');
    }

    public function listAction() {
        $conferenceList = $this->get('conference_repository')->findAllValid();
        return $this->render('CGGConferenceBundle:Conference:list.html.twig', array("conferenceList"=>$conferenceList,"valid"=>true));
    }
    public function listNewConferencesAction(){
        $conferenceList = $this->get('conference_repository')->findAllProgress();
        return $this->render('CGGConferenceBundle:Conference:list.html.twig', array("conferenceList"=>$conferenceList,"valid"=>false ));
    }
    public function validConferenceAction($idConference){
        $conference = $this->get('conference_repository')->find($idConference);
        $conference->setStatus("V");
        $this->get("conference_repository")->save($conference);
        return new RedirectResponse( $this->generateUrl("cgg_conference_listNewConferences"));
    }
    public function declineConferenceAction($idConference){
        $conference = $this->get('conference_repository')->find($idConference);
        $conference->setStatus("D");
        $this->get("conference_repository")->save($conference);
        return new RedirectResponse( $this->generateUrl("cgg_conference_listNewConferences"));
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

        $pages = $this->get('page_repository')->findByConferenceId($idConference);

        foreach ($pages as $page) {
            $conference->addPageId($page);
        }

        $page = $conference->getHomePage();

        $idPage = $page->getId();

        $headBand = $page->getPageHeadBand();

        $menu = $page->getPageMenu();

        $idMenu = $menu->getId();

        $menuItems = $this->get('menuItem_repository')->findByMenuId($idMenu);

        $contents = $this->get('content_repository')->findByPageId($idPage);

        $footer = $page->getPageFooter();

        if ($conference !== NULL) {
            return $this->render('CGGConferenceBundle:Conference:detailConference.html.twig', array(
                'conference' => $conference,
                'headband' => $headBand,
                'menuItems' => $menuItems,
                'contents' => $contents,
                'footer' => $footer
            ));
        } else {
            return $this->render('CGGConferenceBundle:Conference:conferenceNotFound.html.twig', array());
        }
    }
}
