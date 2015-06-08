<?php

namespace CGG\ConferenceBundle\Tools;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;

class MailContactConference {

    private $request;
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

    public function mailContactConference($nom,$prenom,$mail,$sujet,$message,$emailContact){

        $subject = ' Demande de contact ';
        $from = $mail;
        $to = $emailContact;

        $body = $this->template->render('CGGConferenceBundle:Mail:bodyEmailForgotYourPassword.html.twig',
            [
                'message'=>"Nom : ".$nom."<br />".
                           "Prénom : ".$prenom."<br />".
                           "Sujet : ".$sujet."<br /><br />".
                           "Message : ".$message
        ]);

        $this->sendMail($subject, $from, $to, $body);
    }

    public function sendMail($subject, $from, $to, $body){

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