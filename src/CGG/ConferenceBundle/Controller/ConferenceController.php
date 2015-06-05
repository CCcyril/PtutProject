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

                $menuItems = $this->get('menuitem_repository')->findByMenuIdOrderByDepth($idMenu);
                $menuItemsTable = array();
                foreach($menuItems as $menuItem){
                    if($menuItem->getParent() == NULL){
                        $menuItemsTable[$menuItem->getId()] = array();
                        $menuItemsTable[$menuItem->getId()]['menuItem'] = $menuItem;
                        $menuItemsTable[$menuItem->getId()]['children'] = array();
                    }
                }
                foreach($menuItems as $menuItem){
                    if($menuItem->getParent() !== NULL) {
                        $menuItemsTable[$menuItem->getParent()]['children'][] = $menuItem;
                    }
                }
                $menuItems = $this->get('menuItem_repository')->findByMenuIdOrderByDepth($idMenu);

                $contents = $this->get('content_repository')->findByPageId($idPage);

                $footer = $conference->getFooter();


                return $this->render('CGGConferenceBundle:Conference:detailConference.html.twig', array(
                    'menuItems'=>$menuItems,
                    'conference' => $conference,
                    'headband' => $headBand,
                    'menuItemsTable' => $menuItemsTable,
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

        $this->addFlash('success', 'Conférence supprimée avec succès mgl!');

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
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre nom s'il vous plaît");
        }else if(!preg_match("#^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30})$#", $nom)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un nom valide s'il vous plaît");
        }else if($prenom == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre prénom s'il vous plaît");
        }else if(!preg_match("#^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ\s-]{1,30})$#", $prenom)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un prénom valide s'il vous plaît");
        }else if($mail == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre mail s'il vous plaît");
        }else if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner un mail valide s'il vous plaît");
        }else if($sujet == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre sujet s'il vous plaît");
        }else if($message == ""){
            $data = array("erreur"=>true, "message"=>"Veuillez renseigner votre message s'il vous plaît");
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

}

