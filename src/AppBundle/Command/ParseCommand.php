<?php
namespace AppBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\NamespaceSymfony;
use Symfony\Component\DomCrawler\Crawler;

class ParseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:parse')
            ->setDescription('Parse api.symfony.com')
            ->setHelp('This command allows you to parse api.symfony.com and save namespaces to database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $html = file_get_contents('http://api.symfony.com/3.2/index.html');
        $crawler = new Crawler($html);
        $em = $this->getContainer()->get('doctrine')->getManager();

        $namepsaces = $crawler->filter('div.namespace-container > ul > li > a');
        foreach ($namepsaces as $item) {
            $url = 'http://api.symfony.com/3.2/'.$item->getAttribute("href");
            $name = $item->textContent;

            $namespace = new NamespaceSymfony();
            $namespace->setUrl($url);
            $namespace->setName($name);
            $em->persist($namespace);
        }
        $em->flush();
    }
}