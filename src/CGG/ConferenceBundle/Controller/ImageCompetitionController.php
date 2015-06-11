<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 02:15
 */

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\CommentImage;
use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\ImageCompetition;
use CGG\ConferenceBundle\Form\ImageCompetitionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Exception\AclAlreadyExistsException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class ImageCompetitionController extends Controller
{
    public function competitionAction($idConference){
        $imageList = $this->get('image_competition_repository')->findAllByIdConference($idConference);
        $conference = $this->get('conference_repository')->find($idConference);
        $images  = $this->get('knp_paginator')->paginate(
            $imageList,
            $this->get("request")->query->get('page', 1),8
        );
        return $this->render('CGGConferenceBundle:Conference:imageCompetition.html.twig',array(
            "imageList"=>$images,
            "idConf"=>$idConference,
            "conference"=>$conference,
            "order"=>'0'
        ));
    }

    public function competitionOrderedAction(Request $request, $idConference){
        $conference = $this->get('conference_repository')->find($idConference);
        if ($request->isMethod('POST')) {
            $imageList = $this->get('image_competition_repository')->findALlByOrder($idConference, $request->request->get('order'));
            $order = $request->request->get('order');
        } else {
            $imageList = $this->get('image_competition_repository')->findAllByIdConference($idConference);
            $order = '0';
        }
        $images  = $this->get('knp_paginator')->paginate(
            $imageList,
            $this->get("request")->query->get('page', 1),8
        );
        return $this->render('CGGConferenceBundle:Conference:imageCompetition.html.twig',array(
            "imageList" => $images,
            "idConf" => $idConference,
            "order" => $order,
            "conference"=>$conference
        ));
    }

    public function showModalAction(){
        /* Recupère les datas de l'ajax */
        $request = $this->container->get('request');
        $idImage = $request->request->get('idImage');

        $image = $this->get('image_competition_repository')->findByIdImage($idImage);
        $listCommentsbdd = $this->get('comments_image_competition_repository')->findByIdImage($idImage);
        $listComments = array();
        foreach($listCommentsbdd as $comments){
            array_push($listComments, $comments->getComment());
        }
        $response = new Response();
        $response->setContent(json_encode(array(
            'path' => $image->getPath(),
            'title' =>$image->getTitle(),
            'description' =>$image->getDescription(),
            'rating' => $image->getRating(),
            'nbComment' => $image->getNbComment(),
            'listComments' => $listComments
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

        $user= $this->get('security.context')->getToken()->getUser();
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($imageCompetition);
        try{
            $acl = $aclProvider->createAcl($objectIdentity);
        }catch (AclAlreadyExistsException $e){
            $acl = $aclProvider->findAcl($objectIdentity);
        }


        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_VIEW);
        $aclProvider->updateAcl($acl);


        $this->get('image_competition_repository')->save($imageCompetition);
        $response = new Response();
        return $response;
    }

    public function addImageAction(Request $request, $idConference)
    {
        /* TODO : Validation + resize */
        $imageCompetition = new ImageCompetition();
        $conference = $this->get('conference_repository')->find($idConference);
        $form = $this->createForm(New ImageCompetitionType(), $imageCompetition);
        $imageCompetition->setRating(0);
        $imageCompetition->setNbComment(0);
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
    public function listImagesCompetitionAction(){
        $imageList = $this->get('image_competition_repository')->findAll();


        $images  = $this->get('knp_paginator')->paginate(
            $imageList,
            $this->get("request")->query->get('page', 1),8
        );
        return $this->render('CGGConferenceBundle:Admin:listImageCompetition.html.twig',array("imageList"=>$images));
    }
    public function deleteImageAction(){
        /* Recupère les datas de l'ajax */
        $request = $this->container->get('request');
        $idImage = $request->request->get('idImage');

        $imageCompetition = $this->get('image_competition_repository')->findByIdImage($idImage);

        /* TODO: correction bug si l'image a des commentaires */
        $listComments = $this->get('comments_image_competition_repository')->findByIdImage($idImage);
        foreach($listComments as $comment){
            $this->get('comments_image_competition_repository')->delete($comment);
        }
        $imageCompetition->removeUpload();
        $this->get('image_competition_repository')->delete($imageCompetition);

        $this->addFlash('success', 'Votre image a été supprimée avec succès');
        $response = new Response();
        return $response;
    }
    public function addCommentaireAction()
    {
        $request = $this->container->get('request');
        $idImage = $request->request->get('idImage');
        $comment = $request->request->get('comment');
        $nombreComment = $request->request->get('nbComment');
        $imageCompetition = new ImageCompetition();
        $imageCompetition = $this->get('image_competition_repository')->findByIdImage($idImage);
        $commentImageCompetition = new CommentImage();
        $commentImageCompetition->setComment($comment);
        $commentImageCompetition->setImageId($imageCompetition);
        $this->get('comments_image_competition_repository')->save($commentImageCompetition);

        /* Met a jour le nombre de commentaires */
        $imageCompetition->setNbComment($nombreComment);
        $this->get('image_competition_repository')->save($imageCompetition);


        $response = new Response();
        return $response;
    }
}