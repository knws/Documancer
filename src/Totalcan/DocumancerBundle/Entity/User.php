<?php

namespace Totalcan\DocumancerBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Totalcan\DocumancerBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     *
     */
    private $roles;

    public function getRoles()
    {
        return $this->roles->toArray();
    }


    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

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
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="userId")
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Template", mappedBy="userId")
     */
    protected $templates;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="users")
     * @ORM\JoinColumn(name="companyId", referencedColumnName="id")
     */
    private $companyId;

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
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->roles = new ArrayCollection();
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

    /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->date = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdated2Value()
    {
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setPasswordValue()
    {
        $this->password = sha1($this->password.'{'.$this->salt.'}');
    }

   /**
     * @ORM\PrePersist
     */
    public function setPassword2Value()
    {
        $this->password = sha1($this->password.'{'.$this->salt.'}');
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add roles
     *
     * @param \Totalcan\DocumancerBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Totalcan\DocumancerBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Totalcan\DocumancerBundle\Entity\Role $roles
     */
    public function removeRole(\Totalcan\DocumancerBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    public function getRolesAsCollection()
    {
        return $this->roles;
    }

    /**
     * Set companyId
     *
     * @param \Totalcan\DocumancerBundle\Entity\Company $companyId
     * @return User
     */
    public function setCompanyId(\Totalcan\DocumancerBundle\Entity\Company $companyId = null)
    {
        $this->companyId = $companyId;
    
        return $this;
    }

    /**
     * Get companyId
     *
     * @return \Totalcan\DocumancerBundle\Entity\Company 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }
}