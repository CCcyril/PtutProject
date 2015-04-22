<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 23:14
 */

namespace CGG\ConferenceBundle\DataFixtures\ORM;


use CGG\ConferenceBundle\Entity\Role;
use CGG\ConferenceBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $entityManager){
        $admin = new User();
        $jury = new User();
        $user = new User();
        $adminRole = new Role('ROLE_ADMIN');
        $entityManager->persist($adminRole);
        $userRole = new Role('ROLE_USER');
        $entityManager->persist($userRole);
        $juryRole = new Role('ROLE_JURY');
        $entityManager->persist($juryRole);

        $admin->setLname('admin');
        $admin->setfname('admin');
        $admin->setUsername('admin');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($admin);
        $admin->setPassword($encoder->encodePassword('admin', $user->getSalt()));
        $admin->setEmail('admin@admin.fr');
        $admin->setPhone('0123456789');
        $admin->setAddress('admin_adress');
        $admin->setCountry('adminCountry');
        $admin->setZipcode('01234');
        $admin->setStatus('admin');
        $admin->setInscriptionDate(\date('r'));
        $admin->setRoles($adminRole);
        $entityManager->persist($admin);

        $jury->setLname('jury');
        $jury->setfname('jury');
        $jury->setUsername('jury');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($jury);
        $jury->setPassword($encoder->encodePassword('jury', $user->getSalt()));
        $jury->setEmail('jury@jury.fr');
        $jury->setPhone('0123456789');
        $jury->setAddress('jury_adress');
        $jury->setCountry('juryCountry');
        $jury->setZipcode('01234');
        $jury->setStatus('jury');
        $jury->setInscriptionDate(\date('r'));
        $jury->setRoles($juryRole);
        $entityManager->persist($jury);

        $user->setLname('user');
        $user->setfname('user');
        $user->setUsername('user');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($jury);
        $user->setPassword($encoder->encodePassword('jury', $user->getSalt()));
        $user->setEmail('user@user.fr');
        $user->setPhone('0123456789');
        $user->setAddress('user_adress');
        $user->setCountry('userCountry');
        $user->setZipcode('01234');
        $user->setStatus('user');
        $user->setInscriptionDate(\date('r'));
        $user->setRoles($userRole);
        $entityManager->persist($user);

        $entityManager->flush();
    }
}