<?php

namespace PHPSP\Bundles\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPSP\Bundles\WebBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PHPSP\Bundles\WebBundle\Entity\UserRepository")
 */
class User
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $handle
     *
     * @ORM\Column(name="handle", type="string", length=100)
     */
    private $handle;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=100)
     */
    private $token;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var boolean $isAdmin
     *
     * @ORM\Column(name="isAdmin", type="boolean")
     */
    private $isAdmin;


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
     * Set handle
     *
     * @param string $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * Get handle
     *
     * @return string 
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Set token
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Set isAdmin
     *
     * @param boolean $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get isAdmin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
}