<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class InterfaceSymfony
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
     * @ORM\ManyToOne(targetEntity="NamespaceSymfony", inversedBy="interfaces")
     */
    private $namespaceSymfony;

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
    public function getIdNamespace()
    {
        return $this->idNamespace;
    }

    /**
     * @param mixed $idNamespace
     */
    public function setIdNamespace($idNamespace)
    {
        $this->idNamespace = $idNamespace;
    }

    /**
     * @return mixed
     */
    public function getNamespaceSymfony()
    {
        return $this->namespaceSymfony;
    }

    /**
     * @param mixed $namespaceSymfony
     */
    public function setNamespaceSymfony($namespaceSymfony)
    {
        $this->namespaceSymfony = $namespaceSymfony;
    }
}