<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 02:15
 */

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\ImageCompetition;
use CGG\ConferenceBundle\Form\ImageCompetitionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageCompetitionController extends Controller
{
    public function competitionAction($idConference){
        $imageList = $this->get('image_competition_repository')->findAllByIdConference($idConference);
        return $this->render('CGGConferenceBundle:Conference:imageCompetition.html.twig',array("imageList"=>$imageList, "idConf"=>$idConference));
    }
    public function showModalAction(){
        /* Recupère les datas de l'ajax */
        $request = $this->container->get('request');
        $idImage = $request->request->get('idImage');

        $image = $this->get('image_competition_repository')->findByIdImage($idImage);
        $response = new Response();
        $response->setContent(json_encode(array(
            'path' => $image->getPath(),
            'title' =>$image->getTitle(),
            'description' =>$image->getDescription(),
            'rating' => $image->getRating()
        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    public function addRatingAction(){
        $request = $this->container->get('request');
        $idImage = $request->request->get('idImage');
        $valueRating = $request->request->get('valueRating');
        $imageCompetition = new ImageCompetition();
        $imageCompetition = $this->get('image_competition_repository')->findByIdImage($idImage);
        $imageCompetition->setRating($valueRating);
        $this->get('image_competition_repository')->save($imageCompetition);
        $response = new Response();
        return $response;
    }

    public function addImageAction(Request $request, $idConference)
    {
        /*TODO : Validation + file*/
        $imageCompetition = new ImageCompetition();
        $conference = $this->get('conference_repository')->find($idConference);
        $form = $this->createForm(New ImageCompetitionType(), $imageCompetition);
        $imageCompetition->setRating(0);
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()) {
                $imageCompetition->setConferenceId($conference);
                $imageCompetition->upload();
                $this->get('image_competition_repository')->save($imageCompetition);
                return $this->competitionAction($idConference);
            }
        }
        return $this->render('CGGConferenceBundle:Conference:addImageCompetition.html.twig', ['form'=>$form->createView()]);
    }
}