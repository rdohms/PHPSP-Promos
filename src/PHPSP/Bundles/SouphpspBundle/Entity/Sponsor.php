<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPSP\Bundles\SouphpspBundle\Entity\Sponsor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PHPSP\Bundles\SouphpspBundle\Entity\SponsorRepository")
 */
class Sponsor
{
    const BRONZE   = 0;
    const SILVER   = 1;
    const GOLD     = 2;
    const PLATINUM = 3;
    
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
     */
    private $name;

    /**
     * @var string $site
     *
     * @ORM\Column(name="site", type="string", length=200)
     */
    private $site;

    /**
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=150)
     */
    private $logo;


    /**
     * @var string $category
     * 
     * @ORM\Column(type="integer")
     */
    private $category;
    
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
     * Set logo
     *
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }
    
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }


    public function __toString()
    {
        return $this->getName();
    }
}