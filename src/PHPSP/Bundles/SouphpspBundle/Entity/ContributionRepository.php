<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ContributionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContributionRepository extends EntityRepository
{
    
    public function findMyContributions($uid)
    {
        
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.userId = ?0');
        
        $qb->setParameter(0, $uid);
        
        $qb->orderBy('c.dateApproved', 'DESC');
        $qb->orderBy('c.dateAdded', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function getByStatus($status)
    {
        
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.status = ?0');
        
        $qb->setParameter(0, $status);
        
        $qb->orderBy('c.dateApproved', 'DESC');
        $qb->orderBy('c.dateAdded', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * @todo make function return entity in aliased field, not 0
     * @return type 
     */
    public function getTopContributors($limit = 10)
    {
    
        $qb = $this->createQueryBuilder('c');
        
        $qb->addSelect('COUNT(DISTINCT c.id) as contribs');
        $qb->addGroupBy('c.userId');

        $qb->orderBy('contribs', 'DESC');
        
        $qb->setMaxResults($limit);
        
        return $qb->getQuery()->getResult();
    }
    
    public function getStats()
    {
        $countDQL = "SELECT COUNT(c.id) FROM SouphpspBundle:Contribution c";
        
        $topProjectDQL = "SELECT COUNT(DISTINCT c.id) pCount, c, p FROM SouphpspBundle:Contribution c JOIN c.project p GROUP BY c.project ORDER BY pCount DESC";
        
        $statusDQL = "SELECT COUNT(DISTINCT c.id) sCount, c.status FROM SouphpspBundle:Contribution c GROUP BY c.status ORDER BY c.status DESC";
        
        $stats = array();
        $stats['total'] = $this->getEntityManager()->createQuery($countDQL)->getSingleScalarResult();
        $stats['top_project'] = $this->getEntityManager()->createQuery($topProjectDQL)->setMaxResults(1)->getResult();
        $stats['status'] = $this->getEntityManager()->createQuery($statusDQL)->getScalarResult();
        
        return $stats;
    }
}