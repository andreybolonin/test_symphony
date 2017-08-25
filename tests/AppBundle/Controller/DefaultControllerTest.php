<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //$this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());

    }

    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/create');

        $form = $crawler->selectButton('article[save]')->form();
        $form['article[name]'] = 'AutoTest';
        $form['article[description]'] = 'AutoTesting';

        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testDelete()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/delete');

        $url = $crawler->selectLink('Delete')->link();
        $client->click($url);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
