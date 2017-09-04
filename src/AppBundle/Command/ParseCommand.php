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
        $html = file_get_contents('http://api.symfony.com/3.2/');
        $crawler = new Crawler($html);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $namepsaces = $crawler->filter('div.namespace-container > ul > li > a');

        foreach ($namepsaces as $itemNamespace) {
            $namespaceUrl = 'http://api.symfony.com/3.2/'.$itemNamespace->getAttribute("href");
            $namespaceName = $itemNamespace->textContent;

            $namespace = new NamespaceSymfony();
            $namespace->setUrl($namespaceUrl);
            $namespace->setName($namespaceName);
            $em->persist($namespace);

            $htmlNamespaceForClass = file_get_contents($namespaceUrl);
            $crawlerClass = new Crawler($htmlNamespaceForClass);

            $classes = $crawlerClass->filter('div#page-content > div.container-fluid.underlined > div.row > div.col-md-6 > a');

            foreach ($classes as $itemClass) {
                $classUrl = 'http://api.symfony.com/3.2/'.str_replace("../", "", $itemClass->getAttribute("href"));
                $className = $itemClass->textContent;
                $class = new ClassSymfony();

                $class->setUrl($classUrl);
                $class->setName($className);
                $class->setNamespaceSymfony($namespace);
                $em->persist($class);
            }

            $htmlNamespaceForInterface = file_get_contents($namespaceUrl);
            $crawlerInterface = new Crawler($htmlNamespaceForInterface);

            $interfaces = $crawlerInterface->filter('div.container-fluid.underlined > div.row > div.col-md-6 > em > a');

            foreach ($interfaces as $itemInterface) {
                $interfaceUrl = 'http://api.symfony.com/3.2/'.str_replace("../", "", $itemInterface->getAttribute("href"));
                $interfaceName = $itemInterface->textContent;
                $interface = new InterfaceSymfony();

                $interface->setUrl($interfaceUrl);
                $interface->setName($interfaceName);
                $interface->setNamespaceSymfony($namespace);
                $em->persist($interface);
            }
        }
        $em->flush();
    }
}