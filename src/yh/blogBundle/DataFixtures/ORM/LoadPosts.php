<?php

namespace yh\blogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use yh\postBundle\Entity\Posts;

class LoadPosts extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {

    private $getContainer;

    public function load(ObjectManager $manager) {

        $post = new Posts();
        $post->setAuthor("admin");
        $post->setUser($this->getReference('auteur-auteur'));
        $post->setTitle("Article 1");
        $post->setSummary("Un petit extrait");
        $post->setContent("L'article...");
        $post->setCreatedAt(new \Datetime('NOW'));
        $post->setContenthtml("L'article>");
        $manager->persist($post);

        $post2 = new Posts();
        $post2->setAuthor("admin");
        $post2->setUser($this->getReference('auteur-auteur'));
        $post2->setTitle("Article 2");
        $post2->setSummary("Un petit extrait");
        $post2->setContent("L'article...");
        $post2->setCreatedAt(new \Datetime('NOW'));
        $post2->setContenthtml("L'article");
        $manager->persist($post2);


        $post3 = new Posts();
        $post3->setAuthor("admin");
        $post3->setUser($this->getReference('admin-admin'));
        $post3->setTitle("Article 3");
        $post3->setSummary("Un petit extrait");
        $post3->setContent("L'article...");
        $post3->setCreatedAt(new \Datetime('NOW'));
        $post3->setContenthtml("L'article>");
        $manager->persist($post3);

        $post4 = new Posts();
        $post4->setAuthor("admin");
        $post4->setUser($this->getReference('admin-admin'));
        $post4->setTitle("Article 4");
        $post4->setSummary("Un petit extrait");
        $post4->setContent("L'article...");
        $post4->setCreatedAt(new \Datetime('NOW'));
        $post4->setContenthtml("L'article");
        $manager->persist($post4);
        
        $post5 = new Posts();
        $post5->setAuthor("admin");
        $post5->setUser($this->getReference('admin-admin'));
        $post5->setTitle("Article 5");
        $post5->setSummary("Un petit extrait");
        $post5->setContent("L'article...");
        $post5->setCreatedAt(new \Datetime('NOW'));
        $post5->setContenthtml("L'article");
        $manager->persist($post5);
        
        $post6 = new Posts();
        $post6->setAuthor("admin");
        $post6->setUser($this->getReference('admin-admin'));
        $post6->setTitle("Article 6");
        $post6->setSummary("Un petit extrait");
        $post6->setContent("L'article...");
        $post6->setCreatedAt(new \Datetime('NOW'));
        $post6->setContenthtml("L'article>");
        $manager->persist($post6);

        $post7 = new Posts();
        $post7->setAuthor("admin");
        $post7->setUser($this->getReference('admin-admin'));
        $post7->setTitle("Article 7");
        $post7->setSummary("Un petit extrait");
        $post7->setContent("L'article...");
        $post7->setCreatedAt(new \Datetime('NOW'));
        $post7->setContenthtml("L'article");
        $manager->persist($post7);


        $post8 = new Posts();
        $post8->setAuthor("admin");
        $post8->setUser($this->getReference('admin-admin'));
        $post8->setTitle("Article 8");
        $post8->setSummary("Un petit extrait");
        $post8->setContent("L'article...");
        $post8->setCreatedAt(new \Datetime('NOW'));
        $post8->setContenthtml("L'article>");
        $manager->persist($post8);

        $post10 = new Posts();
        $post10->setAuthor("admin");
        $post10->setUser($this->getReference('admin-admin'));
        $post10->setTitle("Article 9");
        $post10->setSummary("Un petit extrait");
        $post10->setContent("L'article...");
        $post10->setCreatedAt(new \Datetime('NOW'));
        $post10->setContenthtml("L'article");
        $manager->persist($post10);
        
        $post10 = new Posts();
        $post10->setAuthor("admin");
        $post10->setUser($this->getReference('admin-admin'));
        $post10->setTitle("Article 10");
        $post10->setSummary("Un petit extrait");
        $post10->setContent("L'article...");
        $post10->setCreatedAt(new \Datetime('NOW'));
        $post10->setContenthtml("L'article");
        $manager->persist($post10);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->getContainer = $container;
    }

    public function getOrder() {
        return 100;
    }

}
