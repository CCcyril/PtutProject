<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 23:14
 */

namespace CGG\ConfrenceBundle\DataFixtures\ORM;

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
        $superAdmin = new User();
        $admin = new User();
        $jury = new User();
        $user = new User();
        $user2 = new User();
        $user3 = new User();
        $roleSuperAdmin = new Role('superAdmin', 'ROLE_SUPERADMIN');
        $entityManager->persist($roleSuperAdmin);
        $roleAdmin = new Role('admin', 'ROLE_ADMIN');
        $entityManager->persist($roleAdmin);
        $roleJury = new Role('jury', 'ROLE_JURY');
        $entityManager->persist($roleJury);
        $roleUser = new Role('user', 'ROLE_USER');
        $entityManager->persist($roleUser);

        $superAdmin->setUsername('superAdmin');
        $superAdmin->setEmail('superAdmin@superAdmin.fr');
        $plainPassword = 'superAdmin';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($superAdmin, $plainPassword);
        $superAdmin->setPassword($encoded);
        $superAdmin->addRole($roleSuperAdmin);
        $entityManager->persist($superAdmin);

        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.fr');
        $plainPassword = 'admin';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($admin, $plainPassword);
        $admin->setPassword($encoded);
        $admin->addRole($roleAdmin);
        $entityManager->persist($admin);

        $jury->setUsername('jury');
        $jury->setEmail('jury@jury.fr');
        $plainPassword = 'jury';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($jury, $plainPassword);
        $jury->setPassword($encoded);
        $jury->addRole($roleJury);
        $entityManager->persist($jury);

        /*TODO : check pourquoi ce user bug lors de la connexion (pas de role) (pas d'id dans la table role : jury 3 3 user 3 4*/
        $user->setUsername('user');
        $user->setEmail('user@user.fr');
        $plainPassword = 'user';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $jury->addRole($roleUser);
        $entityManager->persist($user);

        $user2->setUsername('user2');
        $user2->setEmail('user2@user2.fr');
        $plainPassword = 'user2';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user2, $plainPassword);
        $user2->setPassword($encoded);
        $user2->addRole($roleUser);
        $entityManager->persist($user2);


        $user3->setUsername('user3');
        $user3->setEmail('user3@user3.fr');
        $plainPassword = 'user3';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user3, $plainPassword);
        $user3->setPassword($encoded);
        $user3->addRole($roleUser);
        $entityManager->persist($user3);

        $entityManager->flush();
    }
}