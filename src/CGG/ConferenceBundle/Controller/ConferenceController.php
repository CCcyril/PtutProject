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

    public function createConferenceAction(Request $request){
        $conference = new Conference();
        $form = $this->createForm(New ConferenceType(), $conference);

        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $this->get('conference_repository')->save($conference);
                return new Response('ok');
            }
        }

        return $this->render('CGGConferenceBundle:Conference:createConference.html.twig', ['form'=>$form->createView()]);
    }
}
