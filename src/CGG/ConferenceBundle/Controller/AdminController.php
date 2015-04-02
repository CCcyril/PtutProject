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

        $menuItems = $this->get('menuItem_repository')->findByMenuIdOrderByDepth($idMenu);

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
        /*TODO : ajouter if xhtmlrequest + verif*/
        /*TODO : Une fonction ajax nommée pour chaque parties, un bouton par partie. Nommé les fonctions pour toutes les appeler si le bouton pour sauver tous les changements est cliqué*/
        $conference = $this->get('conference_repository')->find($idConference);
        $page = $this->get('page_repository')->find($idPage);

        /*TODO : Gérer les images*/
        $headbandTitle = $request->request->get('headbandTitle');
        $headbandText = $request->request->get('headbandText');
        $headband = $conference->getHeadBand();
        $headband->setTitle($headbandTitle);
        $headband->setText($headbandText);

        $menu = $conference->getMenu();
        $menuItems = $this->get('menuItem_repository')->findByMenuIdOrderByDepth($menu->getId());
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

        return new Response('OK');

    }

    public function addMenuItemAction($idConference){

        $conferenceRepository = $this->get('conference_repository');
        $conference = $conferenceRepository->find($idConference);

        $menu = $conference->getMenu();
        $idMenu = $menu->getId();

        $newPage = new Page();
        $newPage->setTitle('Nouvelle page');
        $newPage->setIsHome('0');

        $content = new Content();
        $content->setText( "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem
                            aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                            eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                            consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam
                            quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam,
                            nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse
                            quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?" );


        $menuItem = new MenuItem($newPage);
        $menuItem->setTitle($newPage->getTitle());
        $depth = $this->get('menuitem_repository')->countMenuItemDepth($idMenu);
        $menuItem->setDepth($depth+1);

        $menu->addMenuItem($menuItem);
        $newPage->setPageMenu($menu);
        $newPage->addContent($content);

        $conference->addPageId($newPage);
        $conferenceRepository->save($conference);

        return $this->redirect($this->generateUrl('cgg_conference_adminConference', ['idPage'=>$newPage->getId(), 'idConference'=>$idConference]));
    }
}
