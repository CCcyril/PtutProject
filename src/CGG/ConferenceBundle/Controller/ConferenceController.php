<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Form\Type\ConferenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $conference = $this->get('cgg_default_conference')->defaultConferenceAction($conference);

                $this->get('conference_repository')->save($conference);

                $aclProvider = $this->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($conference);
                $acl = $aclProvider ->createAcl($objectIdentity);

                $tokenStorage = $this->get('security.token_storage');
                $user = $tokenStorage->getToken()->getUser();
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

                $menuItems = $this->get('menuItem_repository')->findByMenuId($idMenu);

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

        $this->addFlash('success', 'Conférence supprimée avec succès mgl!');

        return $this->listAction();
    }

}

