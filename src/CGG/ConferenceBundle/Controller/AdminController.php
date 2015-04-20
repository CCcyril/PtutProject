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

class AdminController extends Controller
{
    public function adminAction($idConference) {

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
            return $this->render('::conferenceBase.html.twig', array(
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
