<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPSP\Bundles\SouphpspBundle\Entity\Contribution
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PHPSP\Bundles\SouphpspBundle\Entity\ContributionRepository")
 */
class Contribution
{
    const DENIED   = 0;
    const APPROVED = 1;
    const PENDING  = 2;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $userId
     *
     * @ORM\Column(name="userId", type="string", length=30)
     */
    private $userId;

    /**
     * @var object $project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     */
    private $project;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=150)
     */
    private $type;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $reference
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var text $notes
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var integer $status
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string $mentorId
     *
     * @ORM\Column(name="mentorId", type="string", length=30, nullable=true)
     */
    private $mentorId;

    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $reasonDenied;
    
    /**
     * @var datetime $dateAdded
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;

    /**
     * @var datetime $dateApproved
     *
     * @ORM\Column(name="dateRevised", type="datetime", nullable=true)
     */
    private $dateRevised;

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
     * Set userId
     *
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set project
     *
     * @param object $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * Get project
     *
     * @return object 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set reference
     *
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set notes
     *
     * @param text $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get notes
     *
     * @return text 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set mentorId
     *
     * @param string $mentorId
     */
    public function setMentorId($mentorId)
    {
        $this->mentorId = $mentorId;
    }

    /**
     * Get mentorId
     *
     * @return string 
     */
    public function getMentorId()
    {
        return $this->mentorId;
    }

    /**
     * Set dateAdded
     *
     * @param datetime $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * Get dateAdded
     *
     * @return datetime 
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set $dateApproved
     *
     * @param datetime $dateApproved
     */
    public function setDateRevised($dateRevised)
    {
        $this->dateRevised = $dateRevised;
    }

    /**
     * Get $dateApproved
     *
     * @return datetime 
     */
    public function getDateRevised()
    {
        return $this->dateRevised;
    }
    
    public function getReasonDenied()     
    {
        return $this->reasonDenied;
    }

    public function setReasonDenied($reasonDenied)
    {
        $this->reasonDenied = $reasonDenied;
    }

    public function getProjectOther(){}
    public function setProjectOther($projectOther){}
    public function getTypeOther(){}
    public function setTypeOther($typeOther){}

}