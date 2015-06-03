<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\MenuItem;
use CGG\ConferenceBundle\Form\ConferenceType;
use CGG\ConferenceBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CGG\ConferenceBundle\Form\Type\ContentType;

class AdminController extends Controller
{
    public function adminAction($idConference, $idPage) {

        $conference = $this->get('conference_repository')->find($idConference);
        if ($conference !== NULL) {
            $pages = $this->get('page_repository')->findByConferenceId($idConference);
            if ($this->get('check_if_page_belong_conference')->checkIfPageBelongConference()) {
                foreach ($pages as $page) {
                    $conference->addPageId($page);
                }

                $form = $this->createForm(New ContentType());

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

                return $this->render('CGGConferenceBundle:Admin:adminConference.html.twig', array(
                    'menuItems'=>$menuItems,
                    'conference' => $conference,
                    'headband' => $headBand,
                    'contents' => $contents,
                    'footer' => $footer,
                    'form' => $form->createView()
                ));

            }else{
                return $this->render('CGGConferenceBundle:Conference:pageNotFound.html.twig', array());
            }
        }else{
            return $this->render('CGGConferenceBundle:Conference:conferenceNotFound.html.twig', array());
        }
    }

    public function saveChangesAdminConferenceAction(Request $request, $idConference, $idPage){
        if($request->isXmlHttpRequest()) {
            $conference = $this->get('conference_repository')->find($idConference);
            $page = $this->get('page_repository')->find($idPage);

            $headbandTitle = $request->request->get('headbandTitle');
            $headbandText = $request->request->get('headbandText');
            $headband = $conference->getHeadBand();
            $headband->setTitle($headbandTitle);
            $headband->setText($headbandText);

            $menu = $conference->getMenu();
            $idMenu = $menu->getId();
            $menuItems = $this->get('menuItem_repository')->findByMenuIdOrderByDepth($idMenu);
            $numberIdMenuItem = 1;
            foreach ($menuItems as $menuItem) {
                $menuItemTitle = $request->request->get('menuItemTitle' . $numberIdMenuItem);
                $menuItem->setTitle($menuItemTitle);
                $numberIdMenuItem += 1;
            }

            $contents = $this->get('content_repository')->findByPageId($idPage);
            $numberIdContent = 1;
            foreach ($contents as $content) {
                $contentText = $request->request->get('content' . $numberIdContent);
                $content->setText($contentText);
                $numberIdContent += 1;
            }

            $footer = $conference->getFooter();
            $footerText = $request->request->get('footerText');
            $footer->setText($footerText);

            $this->get('page_repository')->save($page);
            $this->get('conference_repository')->save($conference);

            $this->addFlash('success', 'Modifications enregistrées avec succès, c\'est le plus beau jour de ta vie');

            return new Response('ok');
        }
    }

    public function addMenuItemAction($idConference){

        $conferenceRepository = $this->get('conference_repository');
        $conference = $conferenceRepository->find($idConference);

        $menu = $conference->getMenu();
        $idMenu = $menu->getId();

        $newPage = $this->createNewPage();

        $menuItem = new MenuItem($newPage);
        $menuItem->setTitle($newPage->getTitle());
        $depth = $this->get('menuitem_repository')->countMenuItemDepth($idMenu);
        $menuItem->setDepth($depth+1);

        $menu->addMenuItem($menuItem);

        $conference->addPageId($newPage);
        $conferenceRepository->save($conference);

        return $this->redirect($this->generateUrl('cgg_conference_adminConference', ['idPage'=>$newPage->getId(), 'idConference'=>$idConference]));
    }

    public function saveChangeContentAction(Request $request){
        $idConference = $request->request->get('idConference');
        $idPage = $request->request->get('idPage');
        $entity = $request->request->get('entity');
        $content = $request->request->get('content');
        $idContent = $request->request->get('idContent');

        $conference = $this->get('conference_repository')->find($idConference);

        switch ($entity) {
            case 'headBandTitle':
                $modifiedContent = $conference->getHeadband();
                $modifiedContent->setTitle($content);
                $repo = 'headband_repository';
                break;
            case 'headBandText':
                $modifiedContent = $conference->getHeadband();
                $modifiedContent->setText($content);
                $repo = 'headband_repository';
                break;
            case 'contentText':
                $modifiedContent = $this->get('content_repository')->find($idContent);
                $modifiedContent->setText($content);
                $repo = 'content_repository';
                break;
            case 'footerText':
                $modifiedContent = $conference->getFooter();
                $modifiedContent->setText($content);
                $repo = 'footer_repository';
                break;
        }

        $this->get($repo)->save($modifiedContent);
        $this->addFlash('success', 'Changements effectués avec succccceeeeeyyyyyy');
        return new Response('ok');
    }

    public function addSubItemAction(Request $request){

        $conferenceRepository = $this->get('conference_repository');
        $idConference = $request->request->get('idConference');
        $conference = $conferenceRepository->find($idConference);

        $menu = $conference->getMenu();
        $idMenu = $menu->getId();

        $newPage = $this->createNewPage();

        $menuItem = new MenuItem($newPage);
        $menuItem->setTitle($newPage->getTitle());
        $depth = $this->get('menuitem_repository')->countMenuItemDepth($idMenu);
        $menuItem->setDepth($depth+1);
        $idParent = $request->request->get('idParent');
        $menuItem->setParent($idParent);

        $menu->addMenuItem($menuItem);

        $conference->addPageId($newPage);
        $conferenceRepository->save($conference);

        $this->addFlash('success', 'Sous menu ajouté avec SSSSUSUUUUUUUUUUUSSSSSSSSS(ccey)');

        return new Response('ok');
    }

    public function removePageAction(Request $request){
        $idMenuItem = $request->request->get('idMenuItem');
        $menuItem = $this->get('menuitem_repository')->find($idMenuItem);
        $children = $this->get('menuitem_repository')->findMenuItemChildren($idMenuItem, $menuItem->getMenu()->getId());

        foreach($children as $child){
            $page = $child->getPage();
            $this->get('menuitem_repository')->removeMenuItem($child);
            $this->get('page_repository')->removePage($page);
        }

        $page = $menuItem->getPage();
        $this->get('menuitem_repository')->removeMenuItem($menuItem);
        $this->get('page_repository')->removePage($page);
        $this->addFlash('success', 'Page ' . $page->getTitle() . ' a été supprimée');
        return new Response('ok');
    }

    public function createNewPage(){

        $newPage = new Page();
        $newPage->setTitle('Nouvelle page');
        $newPage->setHome('0');

        $content = new Content();
        $content->setText( "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem
                            aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                            eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                            consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam
                            quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam,
                            nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                            quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?" );

        $newPage->addContent($content);

        return $newPage;
    }

    public function saveSettingAction(){
        /* Recupère les datas de l'ajax */
        $request = $this->container->get('request');
        $idConference = $request->request->get('idConference');
        $mainColor = $request->request->get('mainColor');
        $secondaryColor = $request->request->get('secondaryColor');
        $emailContact = $request->request->get('emailContact');

        $conference = $this->get('conference_repository')->find($idConference);

        $conference->setMainColor($mainColor);
        $conference->setSecondaryColor($secondaryColor);
        $conference->setEmailContact($emailContact);

        $this->get('conference_repository')->save($conference);
        $response = new Response();
        return $response;
    }

    public function addContentAction(Request $request){
        $idPage = $request->request->get('idPage');
        $page = $this->get('page_repository')->find($idPage);
        $content = new Content();

        $content->setPage($page);
        $content->setText('');

        $this->get('content_repository')->save($content);

        return new Response('ok');
    }

    public function deleteContentAction(Request $request){
        $idContent = $request->request->get('idContent');
        $content = $this->get('content_repository')->find($idContent);

        $this->get('content_repository')->delete($content);

        return new Response('ok');
    }
}

