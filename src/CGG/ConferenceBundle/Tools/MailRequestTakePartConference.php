<?php

namespace CGG\ConferenceBundle\Tools;

use CGG\ConferenceBundle\Entity\Conference;
use CGG\ConferenceBundle\Entity\User;
use CGG\ConferenceBundle\Repository\UserRepository;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\SecurityContext;

class MailRequestTakePartConference {

    private $context;
    private $user;
    private $mailer;
    private $template;

    public function __construct(SecurityContext $context, \Swift_Mailer $mailer, TwigEngine $template)
    {
        $this->context=$context;
        $this->mailer = $mailer;
        $this->template = $template;
    }

    public function mailRequestTakePartConference(Conference $conference, User $user){

        $this->user = $this->context->getToken()->getUser();
        $username = $this->user->getUsername();
        $conferenceTitle = $conference->getName();

        $subject = $username . ' demande à participer à l\'administration : ' . $conferenceTitle;
        $from = $this->user->getEmail();

        $to = $user->getEmail();

        $body = $this->template->render('CGGConferenceBundle:Mail:bodyEmailRequestTakePartConference.html.twig',
            [
                'user'=>$this->user,
                'conference'=>$conference,
            ]);

        $this->sendMailRequestTakePartConference($subject, $from, $to, $body);
    }

    public function sendMailRequestTakePartConference($subject, $from, $to, $body){

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
            ->setUsername('cggconference@gmail.com')
            ->setPassword('cggconferencePTUT')
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