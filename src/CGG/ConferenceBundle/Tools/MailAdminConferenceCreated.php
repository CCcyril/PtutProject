<?php

namespace CGG\ConferenceBundle\Tools;

use CGG\ConferenceBundle\Repository\PageRepository;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;

class MailAdminConferenceCreated {

    private $request;
    private $conferenceAttributes;
    private $context;
    private $user;
    private $mailer;
    private $template;

    public function __construct(RequestStack $request, SecurityContext $context, \Swift_Mailer $mailer, TwigEngine $template)
    {
        $this->request=$request;
        $this->context=$context;
        $this->mailer = $mailer;
        $this->template = $template;
    }

    public function mailAdminConferenceCreated(){
        $this->conferenceAttributes = $this->request->getCurrentRequest()->request->get('cgg_conferencebundle_conference');
        $conferenceTitle = $this->conferenceAttributes['name'];
        $conferenceDescription = $this->conferenceAttributes['description'];
        $conferenceStartDate = $this->conferenceAttributes['startDate'];
        $conferenceEndDate = $this->conferenceAttributes['endDate'];

        $this->user = $this->context->getToken()->getUser();
        $username = $this->user->getUsername();
        $userEmail = $this->user->getEmail();


        $subject = $username . ' demande à créer une conférence nommée : ' . $conferenceTitle;
        $from = $this->user->getEmail();
        $to = 'cally.cyril@hotmail.fr';

        $body = $this->template->render('CGGConferenceBundle:Mail:bodyEmailAdminConferenceCreated.html.twig',
            [
                'username'=>$username,
                'userEmail'=>$userEmail,
                'conferenceTitle'=>$conferenceTitle,
                'conferenceDescription'=>$conferenceDescription,
                'conferenceStartDate'=>$conferenceStartDate,
                'conferenceEndDate'=>$conferenceEndDate,
            ]);

        $this->sendMailAdminConferenceCreated($subject, $from, $to, $body);
    }

    public function sendMailAdminConferenceCreated($subject, $from, $to, $body){

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
            ->setUsername('yoann.galland71@gmail.com')
            ->setPassword('cafartee')
        ;

        $this->mailer->newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $body,
                'text/html'
            );
        $this->mailer->send($message);
    }

}