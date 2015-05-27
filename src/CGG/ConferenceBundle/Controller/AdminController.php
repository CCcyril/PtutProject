<?php

namespace CGG\ConferenceBundle\Controller;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\Content;
use CGG\ConferenceBundle\Entity\Footer;
use CGG\ConferenceBundle\Entity\HeadBand;
use CGG\ConferenceBundle\Entity\Menu;
use CGG\ConferenceBundle\Entity\MenuItem;
use CGG\ConferenceBundle\Form\ConferenceType;
use Proxies\__CG__\CGG\ConferenceBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function adminAction($idConference, $idPage) {

        $conference = $this->get('conference_repository')->find($idConference);

        $pages = $this->get('page_repository')->findByConferenceId($idConference);

        foreach ($pages as $page) {
            $conference->addPageId($page);
        }

        $headBand = $conference->getHeadBand();

        $menu = $conference->getMenu();

        $idMenu = $menu->getId();

        $menuItems = $this->get('menuItem_repository')->findByMenuId($idMenu);

        $contents = $this->get('content_repository')->findByPageId($idPage);

        $footer = $conference->getFooter();

        if ($conference !== NULL) {
            return $this->render('CGGConferenceBundle:Admin:adminConference.html.twig', array(
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

    public function saveChangesAdminConferenceAction(Request $request, $idConference, $idPage){
        if($request->isXmlHttpRequest()){
            $conference = $this->get('conference_repository')->find($idConference);
            $page = $this->get('page_repository')->find($idPage);


            $headbandTitle = $request->request->get('headbandTitle');
            $headbandText = $request->request->get('headbandText');
            $headband = $conference->getHeadBand();
            $headband->setTitle($headbandTitle);
            $headband->setText($headbandText);

            $menu = $conference->getMenu();
            $menuItems = $this->get('menuItem_repository')->findByMenuId($menu->getId());
            $numberIdMenuItem = 1;
            foreach($menuItems as $menuItem){
                $menuItemTitle = $request->request->get('menuItemTitle'.$numberIdMenuItem);
                $menuItem->setTitle($menuItemTitle);
                $numberIdMenuItem += 1;
            }

            $contents = $this->get('content_repository')->findByPageId($idPage);
            $numberIdContent = 1;
            foreach($contents as $content){
                $contentText = $request->request->get('content'.$numberIdContent);
                $content->setText($contentText);
                $numberIdContent += 1;
            }

            $footer = $conference->getFooter();
            $footerText = $request->request->get('footerText');
            $footer->setText($footerText);

            $this->get('page_repository')->save($page);
            $this->get('conference_repository')->save($conference);
        }
    }

    public function addMenuItemAction($idConference){
        $conferenceRepository = $this->get('conference_repository');
        $conference = $conferenceRepository->find($idConference);
        $menu = $conference->getMenu();
        $newPage = new Page();
        $newPage->setTitle('test');

        $newPage->setIsHome('0');

        $menuItem = new MenuItem($newPage);
        $menuItem->setTitle($newPage->getTitle());
        $menuItem->setDepth(5);

        $menu->addMenuItem($menuItem);
        $newPage->setPageMenu($menu);

        $conference->addPageId($newPage);
        $conferenceRepository->save($conference);

        return $this->redirect($this->generateUrl('cgg_conference_adminConference', ['idPage'=>$newPage->getId(), 'idConference'=>$idConference]));
    }
}
