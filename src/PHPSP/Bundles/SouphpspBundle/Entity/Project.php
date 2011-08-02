<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * PHPSP\Bundles\SouphpspBundle\Entity\Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PHPSP\Bundles\SouphpspBundle\Entity\ProjectRepository")
 */
class Project
{
    const STATUS_OK = 1;
    const STATUS_PENDING = 0;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=150)
     * 
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string $site
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var string $repository
     *
     * @ORM\Column(name="repository", type="string", length=255, nullable=true)
     */
    private $repository;

    /**
     * @var string $howtocontribute
     *
     * @ORM\Column(name="howtocontribute", type="string", length=255, nullable=true)
     */
    private $howtocontribute;

    /**
     * @var string $contactName
     *
     * @ORM\Column(name="contactName", type="string", length=100, nullable=true)
     */
    private $contactName;

    /**
     * @var string $contactEmail
     *
     * @ORM\Column(name="contactEmail", type="string", length=100, nullable=true)
     */
    private $contactEmail;

    /**
     * @var text $about
     *
     * @ORM\Column(name="about", type="text", nullable=true)
     */
    private $about;

    /**
     * @var text $whereToHelp
     *
     * @ORM\Column(name="whereToHelp", type="text", nullable=true)
     */
    private $whereToHelp;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $status;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set site
     *
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set repository
     *
     * @param string $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get repository
     *
     * @return string 
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Set howtocontribute
     *
     * @param string $howtocontribute
     */
    public function setHowtocontribute($howtocontribute)
    {
        $this->howtocontribute = $howtocontribute;
    }

    /**
     * Get howtocontribute
     *
     * @return string 
     */
    public function getHowtocontribute()
    {
        return $this->howtocontribute;
    }

    /**
     * Set contactName
     *
     * @param string $contactName
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set about
     *
     * @param text $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * Get about
     *
     * @return text 
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set whereToHelp
     *
     * @param text $whereToHelp
     */
    public function setWhereToHelp($whereToHelp)
    {
        $this->whereToHelp = $whereToHelp;
    }

    /**
     * Get whereToHelp
     *
     * @return text 
     */
    public function getWhereToHelp()
    {
        return $this->whereToHelp;
    }
    
    public function getStatus()     
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

        
    public function __toString()
    {
        return $this->getName();
    }
}