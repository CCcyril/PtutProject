<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Form\Type\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class ConferenceController extends Controller
{
    public function homeAction() {

        return $this->render('CGGConferenceBundle:Conference:home.html.twig');
    }

    public function listAction() {
        $conferenceList = $this->get('conference_repository')->findAllConferenceByStatus('V');
        foreach($conferenceList as $conference){
            $pages = $this->get('page_repository')->findByConferenceId($conference->getId());
            foreach($pages as $page){
                $conference->addPageId($page);
            }
        }
        return $this->render('CGGConferenceBundle:Conference:list.html.twig', array("conferenceList"=>$conferenceList,"valid"=>true));
    }

    public function listNewConferencesAction(){
        $conferenceList = $this->get('conference_repository')->findAllConferenceByStatus('P');
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
        $conference->setStatus("P");
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $conference = $this->get('cgg_default_conference')->defaultConferenceAction($conference);
                $tokenStorage = $this->get('security.token_storage');
                $user = $tokenStorage->getToken()->getUser();

                $conference->setEmailContact($user->getEmail());
                $this->get('conference_repository')->save($conference);

                $footer = $conference->getFooter();

                $legalPage = $this->get('page_repository')->findLegal($conference->getId());

                $footer->setText('CGG Conférence © 2015 - <a href="/conference/' . $conference->getId() . '/' . $legalPage->getId() . '">Mentions légales</a>');

                $this->get('footer_repository')->save($footer);

                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($conference);

                $acl = $aclProvider ->createAcl($objectIdentity);
                $securityIdentity = UserSecurityIdentity::fromAccount($user);

                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);

                $this->get('mail_admin_conference_created');

                return $this->render('CGGConferenceBundle:Conference:conferenceCreated.html.twig');
            }
        }

        return $this->render('CGGConferenceBundle:Conference:createConference.html.twig', ['form'=>$form->createView()]);
    }

    public function detailAction($idConference, $idPage){

        $conference = $this->get('conference_repository')->find($idConference);

        if ($conference !== NULL) {
            if($this->get('check_if_page_belong_conference')->checkIfPageBelongConference()){

                $headBand = $conference->getHeadBand();

                $menu = $conference->getMenu();

                $idMenu = $menu->getId();

                $menuItems = $this->get('menuitem_repository')->findMenuItemWithoutParentOrderedByDepth($idMenu);

                foreach($menuItems as $menuItem){
                    $idMenuItem = $menuItem->getId();
                    $children = $this->get('menuitem_repository')->findMenuItemChildren($idMenuItem, $idMenu);
                    foreach($children as $child){
                        $menuItem->addChildren($child);
                    }
                }
                $contents = $this->get('content_repository')->findByPageId($idPage);

                $footer = $conference->getFooter();


                return $this->render('CGGConferenceBundle:Conference:detailConference.html.twig', array(
                    'conference' => $conference,
                    'headband' => $headBand,
                    'menuItems' => $menuItems,
                    'contents' => $contents,
                    'footer' => $footer
                ));
            }else{
                return $this->render('CGGConferenceBundle:Conference:pageNotFound.html.twig', array());
            }
        }
        else {
            return $this->render('CGGConferenceBundle:Conference:conferenceNotFound.html.twig', array());
        }

    }

    public function deleteConferenceAction($idConference){
        $conferenceRepo = $this->get('conference_repository');
        $conference = $conferenceRepo->find($idConference);
        $conferenceRepo->removeConference($conference);

        $this->addFlash('success', 'Conférence supprimée avec succès');

        return $this->listAction();
    }

    public function contactConferenceAction(){
        $request = $this->container->get('request');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $mail = $request->request->get('mail');
        $sujet = $request->request->get('sujet');
        $message = $request->request->get('message');
        $data = array();

        if($nom == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre nom ");
        }else if(!preg_match("#^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30})$#", $nom)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un nom valide");
        }else if($prenom == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre prénom");
        }else if(!preg_match("#^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30})$#", $prenom)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un prénom valide");
        }else if($mail == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre mail");
        }else if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un mail valide");
        }else if($sujet == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre sujet");
        }else if($message == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre message");
        }else{
            $idConference = $request->request->get('idConference');
            $conference = $this->get('conference_repository')->find($idConference);
            $this->get('mail_contact_conference')->mailContactConference($nom,$prenom,$mail,$sujet,$message,$conference->getEmailContact());
            $data = array("erreur"=>false, "message"=>"Votre mail à été envoyer avec succes");
        }
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function requestTakePartConferenceAction($idConference){
        $conference = $this->get('conference_repository')->find($idConference);
        $authorizationChecker = $this->get('security.authorization_checker');
        $users = $this->get('user_repository')->findAll();
        foreach($users as $user){
            if($authorizationChecker->isGranted('EDIT', $conference)){
                $owner = $user;

            }
        }
        $this->get('request_take_part_conference')->mailRequestTakePartConference($conference, $owner);
        $this->addFlash('success', 'TA ENVOYER LE MAIL ENFIN');
        return $this->render('CGGConferenceBundle:Conference:home.html.twig');
    }

    public function validateRequestTakePartConferenceAction($idConference, $idUser){
        $user = $this->get('user_repository')->find($idUser);
        $conference = $this->get('conference_repository')->find($idConference);

        // creating the ACL
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($conference);
        $acl = $aclProvider->findAcl($objectIdentity);

        // retrieving the security identity of the currently logged-in user
        $tokenStorage = $this->get('security.token_storage');
        $user = $tokenStorage->getToken()->getUser();
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // grant owner access
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        return $this->render('CGGConferenceBundle:Conference:acceptRequestTakePartConference.html.twig', ['idConference'=>$idConference]);
    }

    public function RefuseRequestTakePartConferenceAction(){
        return $this->render('CGGConferenceBundle:Conference:refuseRequestTakePartConference.html.twig');
    }

}

