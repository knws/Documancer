<?php

namespace Totalcan\DocumancerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TemplateDesign
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Totalcan\DocumancerBundle\Entity\TemplateDesignRepository")
 */
class TemplateDesign
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="templateDesigns")
     * @ORM\JoinColumn(name="userId", referencedColumnName="userId")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="text")
     */
    private $template;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return TemplateDesign
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
     * Set variables
     *
     * @param string $variables
     * @return TemplateDesign
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
     * @return TemplateDesign
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
     * Set userId
     *
     * @param \Totalcan\DocumancerBundle\Entity\User $userId
     * @return TemplateDesign
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
}