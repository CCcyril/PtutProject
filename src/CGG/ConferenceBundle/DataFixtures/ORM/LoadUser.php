<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 01/04/15
 * Time: 23:14
 */

namespace CGG\ConferenceBundle\DataFixtures\ORM;


use CGG\ConferenceBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUser implements FixtureInterface {

    public function load(ObjectManager $entityManager){
        $admin = new User();
        $jury = new User();
        $user = new User();

        $admin->setLname('admin');
        $admin->setfname('admin');
        $admin->setPassword('admin');
        $admin->setEmail('admin@admin.fr');
        $admin->setPhone('0123456789');
        $admin->setAddress('admin_adress');
        $admin->setCountry('adminCountry');
        $admin->setZipcode('01234');
        $admin->setStatus('admin');
        $admin->setInscriptionDate(\date('r'));
        $entityManager->persist($admin);

        $jury->setLname('jury');
        $jury->setfname('jury');
        $jury->setPassword('jury');
        $jury->setEmail('jury@jury.fr');
        $jury->setPhone('0123456789');
        $jury->setAddress('jury_adress');
        $jury->setCountry('juryCountry');
        $jury->setZipcode('01234');
        $jury->setStatus('jury');
        $jury->setInscriptionDate(\date('r'));
        $entityManager->persist($jury);

        $user->setLname('user');
        $user->setfname('user');
        $user->setPassword('user');
        $user->setEmail('user@user.fr');
        $user->setPhone('0123456789');
        $user->setAddress('user_adress');
        $user->setCountry('userCountry');
        $user->setZipcode('01234');
        $user->setStatus('user');
        $user->setInscriptionDate(\date('r'));
        $entityManager->persist($user);

        $entityManager->flush();
    }
}