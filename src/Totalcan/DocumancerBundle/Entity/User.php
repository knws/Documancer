<?php

namespace Totalcan\DocumancerBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Totalcan\DocumancerBundle\Entity\UserRepository")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="variables", type="text")
     */
    private $variables;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="userId")
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Template", mappedBy="userId")
     */
    protected $templates;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="userId")
     */
    protected $clients;

    /**
     * @ORM\OneToMany(targetEntity="Design", mappedBy="userId")
     */
    protected $designs;


    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->templates = new ArrayCollection();
        $this->designs = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set variables
     *
     * @param string $variables
     * @return User
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Get variables
     *
     * @return string
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return User
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add documents
     *
     * @param \Totalcan\DocumancerBundle\Entity\Document $documents
     * @return User
     */
    public function addDocument(\Totalcan\DocumancerBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \Totalcan\DocumancerBundle\Entity\Document $documents
     */
    public function removeDocument(\Totalcan\DocumancerBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Add templates
     *
     * @param \Totalcan\DocumancerBundle\Entity\Template $templates
     * @return User
     */
    public function addTemplate(\Totalcan\DocumancerBundle\Entity\Template $templates)
    {
        $this->templates[] = $templates;

        return $this;
    }

    /**
     * Remove templates
     *
     * @param \Totalcan\DocumancerBundle\Entity\Template $templates
     */
    public function removeTemplate(\Totalcan\DocumancerBundle\Entity\Template $templates)
    {
        $this->templates->removeElement($templates);
    }

    /**
     * Get templates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Add clients
     *
     * @param \Totalcan\DocumancerBundle\Entity\Client $clients
     * @return User
     */
    public function addClient(\Totalcan\DocumancerBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \Totalcan\DocumancerBundle\Entity\Client $clients
     */
    public function removeClient(\Totalcan\DocumancerBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * Add designs
     *
     * @param \Totalcan\DocumancerBundle\Entity\Design $designs
     * @return User
     */
    public function addDesign(\Totalcan\DocumancerBundle\Entity\Design $designs)
    {
        $this->designs[] = $designs;

        return $this;
    }

    /**
     * Remove designs
     *
     * @param \Totalcan\DocumancerBundle\Entity\Design $designs
     */
    public function removeDesign(\Totalcan\DocumancerBundle\Entity\Design $designs)
    {
        $this->designs->removeElement($designs);
    }

    /**
     * Get designs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDesigns()
    {
        return $this->designs;
    }
}