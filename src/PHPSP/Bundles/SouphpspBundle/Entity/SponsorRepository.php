<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SponsorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SponsorRepository extends EntityRepository
{
    
    public function getSponsorsInOrder()
    {
        $qb = $this->createQueryBuilder('s');
        $qb->orderBy('s.category', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
}