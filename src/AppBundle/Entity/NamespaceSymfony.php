<?php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\ClassSymfony;

/**
 * @ORM\Entity
 */
class NamespaceSymfony
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="ClassSymfony", mappedBy="namespaceSymfony")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity="InterfaceSymfony", mappedBy="namespaceSymfony")
     */
    private $interfaces;

    /**
     * NamespaceSymfony constructor.
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->interfaces = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getClasses()
    {
        return $this->classes;
    }
}