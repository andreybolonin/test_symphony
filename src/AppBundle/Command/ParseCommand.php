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
            ->setDescription('Parse api.symfony.com and save to Database')
            ->setHelp('This command allows you to parse api.symfony.com and save namespaces/classes/interfaces to database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getNamespaces('http://api.symfony.com/3.2/Symfony.html');
    }
    public function getNamespaces ($url)
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $namepsaces = $crawler->filter('div.namespace-list > a');
        $classes = $crawler->filter('div.row > div.col-md-6 > a');
        $interfaces = $crawler->filter('div.col-md-6 > em > a');

        foreach ($namepsaces as $itemNamespace) {
            $namespaceUrl = 'http://api.symfony.com/3.2/'.str_replace("../", "", $itemNamespace->getAttribute("href"));
            $namespaceName = $itemNamespace->textContent;

            $namespace = new NamespaceSymfony();
            $namespace->setUrl($namespaceUrl);
            $namespace->setName($namespaceName);
            $em->persist($namespace);
            $this->getNamespaces($namespaceUrl);

            foreach ($classes as $itemClass) {
                $classUrl = 'http://api.symfony.com/3.2/'.str_replace("../", "", $itemClass->getAttribute("href"));
                $className = $itemClass->textContent;
                $class = new ClassSymfony();

                $class->setUrl($classUrl);
                $class->setName($className);
                $class->setNamespaceSymfony($namespace);
                $em->persist($class);
            }

            foreach ($interfaces as $itemInterface) {
                $interfaceUrl = 'http://api.symfony.com/3.2/' . str_replace("../", "", $itemInterface->getAttribute("href"));
                $interfaceName = $itemInterface->textContent;
                $interface = new InterfaceSymfony();
                $interface->setUrl($interfaceUrl);
                $interface->setName($interfaceName);
                $interface->setNamespaceSymfony($namespace);
                $em->persist($interface);
            }
            $em->flush();
        }
    }
}