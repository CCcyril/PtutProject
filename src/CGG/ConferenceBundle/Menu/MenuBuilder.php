<?php
namespace CGG\ConferenceBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class MenuBuilder extends ContainerAware {

    public function mainMenu(FactoryInterface $factory, array $options) {

        $menu = $factory->createItem('root');

        $menu->setChildrenAttributes(array('class' => 'nav navbar-nav'));

        $menu->addChild('Home', array('route' => 'cgg_conference_home'));
        $menu->addChild('Liste des conférences', array('route' => 'cgg_conference_listConferences'));
        $menu->addChild('Création d\'une conférence', array('route' => 'cgg_conference_createConference'));

        return $menu;
    }
}
