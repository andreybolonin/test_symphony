<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Article;

class LoadArticleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setName('test');
        $article->setDescription('test');
        $article->setCreatedAt(new \DateTime());

        $manager->persist($article);

        $article2 = new Article();
        $article2->setName('test111');
        $article2->setDescription('test111');
        $article2->setCreatedAt(new \DateTime());

        $manager->persist($article2);
        $manager->flush();
    }
}