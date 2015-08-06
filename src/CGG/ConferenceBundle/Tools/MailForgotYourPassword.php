<?php

namespace CGG\ConferenceBundle\Tools;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;

class MailForgotYourPassword {

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

    public function mailAdminForgotYourPassword($password){
        $this->user = $this->context->getToken()->getUser();
        $userEmail = $this->user->getEmail();

        $subject = ' Mot de passe oublié : ';
        $from = "admin@cggconference.fr";
        $to = $this->user->getEmail();

        $body = $this->template->render('CGGConferenceBundle:Mail:bodyEmailForgotYourPassword.html.twig',
            [
                'message'=>"Votre nouveau mot de passe : ".$password
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