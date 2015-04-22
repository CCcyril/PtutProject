<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 11/03/15
 * Time: 19:29
 */

namespace CGG\ConferenceBundle\Controller;


use CGG\ConferenceBundle\Entity\User;
use CGG\ConferenceBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

class UserController extends Controller{

    public function registerAction(Request $request){
        $user = new User();
        $form = $this->createForm(New UserType(), $user);
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                if (0 !== strlen($password = $user->getPassword())) {
                    $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                    $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
                    $user->eraseCredentials();
                }
                $this->get('user_repository')->save($user);
                return new Response('ok');
            }
        }
        return $this->render('CGGConferenceBundle:User:register.html.twig', ['form'=>$form->createView()]);
    }
    public function loginAction(){

        return $this->render('CGGConferenceBundle:User:login.html.twig', array());
    }
}