<?php

namespace yh\blogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUsers extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {

    private $getContainer;

    public function load(ObjectManager $manager) {
        $userManager = $this->getContainer->get('fos_user.user_manager');
        
        $user = $userManager->createUser();
        $user->setUsername('user');
        $user->setEmail('user@iknsa.com');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->setLastLogin(new \Datetime('NOW'));
        $user->setRoles(array('ROLE_USER'));
        $manager->persist($user);

        $auteur = $userManager->createUser();
        $auteur->setUsername('auteur');
        $auteur->setEmail('auteur@iknsa.com');
        $auteur->setPlainPassword('auteur');
        $auteur->setEnabled(true);
        $auteur->setLastLogin(new \Datetime('NOW'));
        $auteur->setRoles(array('ROLE_AUTEUR'));
        $manager->persist($auteur);
        
        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@iknsa.com');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setLastLogin(new \Datetime('NOW'));
        $admin->setRoles(array('ROLE_ADMIN', 'ROLE_USER'));
        $manager->persist($admin);

        $this->addReference('user-user', $user);
        $this->addReference('auteur-auteur', $auteur);
        $this->addReference('admin-admin', $admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->getContainer = $container;
    }

    public function getOrder() {
        return 100;
    }

}
