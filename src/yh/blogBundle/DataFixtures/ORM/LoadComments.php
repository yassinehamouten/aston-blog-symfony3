<?php

namespace yh\blogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use yh\commentsBundle\Entity\Comments;

class LoadComments extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {

    private $getContainer;

    public function load(ObjectManager $manager) {

        $comment = new Comments();
        $comment->setUserId(1);
        $comment->setUsername($this->getReference('user-user'));
        $comment->setPostId(1);
        $comment->setCreatedAt(new \Datetime('NOW'));
        $comment->setComment("Bel article");
        $manager->persist($comment);

        $comment2 = new Comments();
        $comment2->setUserId(2);
        $comment2->setUsername($this->getReference('auteur-auteur'));
        $comment2->setPostId(1);
        $comment2->setCreatedAt(new \Datetime('NOW'));
        $comment2->setComment("Un commentaire");
        $manager->persist($comment2);
        
        $comment3 = new Comments();
        $comment3->setUserId(3);
        $comment3->setUsername($this->getReference('admin-admin'));
        $comment3->setPostId(2);
        $comment3->setCreatedAt(new \Datetime('NOW'));
        $comment3->setComment("Un commentaire");
        $manager->persist($comment3);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->getContainer = $container;
    }

    public function getOrder() {
        return 100;
    }

}
