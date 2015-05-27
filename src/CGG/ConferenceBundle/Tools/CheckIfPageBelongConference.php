<?php

namespace CGG\ConferenceBundle\Tools;

use CGG\ConferenceBundle\Repository\PageRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CheckIfPageBelongConference {

    private $pageRepository;
    private $request;

    public function __construct(RequestStack $request, PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->request=$request;
    }

    public function checkIfPageBelongConference(){
        $idConference = $this->request->getCurrentRequest()->attributes->get('idConference');
        $idPage = $this->request->getCurrentRequest()->attributes->get('idPage');
        $pagesInConference = $this->pageRepository->findByConferenceId($idConference);

        foreach($pagesInConference as $page){
            if($page->getId() == $idPage){
                return true;
            }
        }

    }


}