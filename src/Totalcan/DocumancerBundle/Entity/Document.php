<?php

namespace Totalcan\DocumancerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Totalcan\DocumancerBundle\Entity\DocumentRepository")
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="documents")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="Design", inversedBy="documents")
     * @ORM\JoinColumn(name="designId", referencedColumnName="id")
     */
    private $designId;

    /**
     * @ORM\ManyToOne(targetEntity="Template", inversedBy="documents")
     * @ORM\JoinColumn(name="templateId", referencedColumnName="id")
     */
    private $templateId;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="documents")
     * @ORM\JoinColumn(name="clientId", referencedColumnName="id")
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(name="variables", type="text")
     */
    private $variables;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="text")
     */
    private $template;

     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * @return Document
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
     * @return Document
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
     * Set templateId
     *
     * @param \Totalcan\DocumancerBundle\Entity\Template $templateId
     * @return Document
     */
    public function setTemplateId(\Totalcan\DocumancerBundle\Entity\Template $templateId = null)
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Get templateId
     *
     * @return \Totalcan\DocumancerBundle\Entity\Template
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Set userId
     *
     * @param \Totalcan\DocumancerBundle\Entity\User $userId
     * @return Document
     */
    public function setUserId(\Totalcan\DocumancerBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \Totalcan\DocumancerBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set designId
     *
     * @param \Totalcan\DocumancerBundle\Entity\Design $designId
     * @return Document
     */
    public function setDesignId(\Totalcan\DocumancerBundle\Entity\Design $designId = null)
    {
        $this->designId = $designId;

        return $this;
    }

    /**
     * Get designId
     *
     * @return \Totalcan\DocumancerBundle\Entity\Design
     */
    public function getDesignId()
    {
        return $this->designId;
    }

    /**
     * Set clientId
     *
     * @param \Totalcan\DocumancerBundle\Entity\Client $clientId
     * @return Document
     */
    public function setClientId(\Totalcan\DocumancerBundle\Entity\Client $clientId = null)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return \Totalcan\DocumancerBundle\Entity\Client
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Document
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}