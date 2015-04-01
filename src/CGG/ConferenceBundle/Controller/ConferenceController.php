<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
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
    public function detailAction(){
        return $this->render('CGGConferenceBundle:Conference:detailConference.html.twig', array());
    }
}
