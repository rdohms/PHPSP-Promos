<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PHPSP\Bundles\SouphpspBundle\Entity\Challenge
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PHPSP\Bundles\SouphpspBundle\Entity\ChallengeRepository")
 */
class Challenge
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $prize
     *
     * @ORM\Column(name="prize", type="string", length=255)
     */
    private $prize;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer $qtdWinners
     *
     * @ORM\Column(name="qtdWinners", type="integer")
     */
    private $qtdWinners;

    /**
     * @var datetime $startDate
     *
     * @ORM\Column(name="startDate", type="datetime")
     */
    private $startDate;

    /**
     * @var datetime $endDate
     *
     * @ORM\Column(name="endDate", type="datetime")
     */
    private $endDate;

    /**
     * @var object $sponsor
     *
     * @ORM\ManyToOne(targetEntity="Sponsor")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $sponsor;

    /**
     * @var object $project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $project;

    /**
     * @var object $winners
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $winner;


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
     * Set prize
     *
     * @param string $prize
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;
    }

    /**
     * Get prize
     *
     * @return string 
     */
    public function getPrize()
    {
        return $this->prize;
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
     * Set qtdWinners
     *
     * @param integer $qtdWinners
     */
    public function setQtdWinners($qtdWinners)
    {
        $this->qtdWinners = $qtdWinners;
    }

    /**
     * Get qtdWinners
     *
     * @return integer 
     */
    public function getQtdWinners()
    {
        return $this->qtdWinners;
    }

    /**
     * Set startDate
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Get startDate
     *
     * @return datetime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param datetime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Get endDate
     *
     * @return datetime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set sponsor
     *
     * @param object $sponsor
     */
    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * Get sponsor
     *
     * @return object 
     */
    public function getSponsor()
    {
        return $this->sponsor;
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
     * Set winner
     *
     * @param object $winner
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
    }

    /**
     * Get winner
     *
     * @return object 
     */
    public function getWinner()
    {
        return $this->winner;
    }
}