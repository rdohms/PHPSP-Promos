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
    public function getUserContributions($uid)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.userId = ?0');
        $qb->andWhere('c.status != ?1');
        
        $qb->setParameter(0, $uid);
        $qb->setParameter(1, 0);
        
        $qb->orderBy('c.dateRevised', 'DESC');
        $qb->orderBy('c.dateAdded', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
    
    public function findMyContributions($uid)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.userId = ?0');
        
        $qb->setParameter(0, $uid);
        
        $qb->orderBy('c.dateRevised', 'DESC');
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
        
        $qb->andWhere('c.status = ?1');
        
        $qb->addGroupBy('c.userId');

        $qb->orderBy('contribs', 'DESC');
        
        $qb->setMaxResults($limit);
        $qb->setParameter(1, Contribution::APPROVED);
        
        return $qb->getQuery()->getResult();
    }
    
    public function getStats()
    {
        $countDQL = "SELECT COUNT(c.id) FROM SouphpspBundle:Contribution c";
        
        $topProjectDQL = "SELECT COUNT(DISTINCT c.id) pCount, c, p FROM SouphpspBundle:Contribution c JOIN c.project p WHERE c.status != ?1 GROUP BY c.project ORDER BY pCount DESC";
        
        $statusDQL = "SELECT COUNT(DISTINCT c.id) sCount, c.status FROM SouphpspBundle:Contribution c GROUP BY c.status ORDER BY c.status DESC";
        
        $stats = array();
        $stats['total'] = $this->getEntityManager()->createQuery($countDQL)->getSingleScalarResult();
        $stats['top_project'] = $this->getEntityManager()->createQuery($topProjectDQL)->setParameter(1, Contribution::DENIED)->setMaxResults(1)->getResult();
        $stats['status'] = $this->getEntityManager()->createQuery($statusDQL)->getScalarResult();
        
        return $stats;
    }
    
    public function getStatsByUser($id)
    {
        $countDQL = "SELECT COUNT(c.id) FROM SouphpspBundle:Contribution c WHERE c.userId = ?0";
        
        $statusDQL = "SELECT COUNT(DISTINCT c.id) sCount, c.status FROM SouphpspBundle:Contribution c WHERE c.userId = ?0 GROUP BY c.status ORDER BY c.status ASC";
        
        $stats = array();
        $stats['total'] = $this->getEntityManager()->createQuery($countDQL)->setParameter(0, $id)->getSingleScalarResult();
        $stats['status'] = $this->getEntityManager()->createQuery($statusDQL)->setParameter(0, $id)->getScalarResult();
        
        return $stats;
    }
    
    public function getCountByProject($id = null)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->addSelect('COUNT(DISTINCT c.id) pCount');
        $qb->addSelect('c');
        $qb->addSelect('p');
        
        $qb->join('c.project', 'p');
        
        $qb->groupBy('c.project');
        $qb->orderBy('pCount', 'DESC');
        
        $qb->andWhere('c.status != ?0');
        $qb->setParameter(0, Contribution::DENIED);
        
        if ($id !== null) {
            $qb->andWhere('c.project = ?1');
            $qb->setParameter(1, $id);
        }
        
        return $qb->getQuery()->getResult();
    }
    
    public function getCountByType($type = null)
    {
        $qb = $this->createQueryBuilder('c');
        
        $qb->addSelect('COUNT(DISTINCT c.id) cCount');
        $qb->addSelect('c');
        
        $qb->groupBy('c.type');
        $qb->orderBy('cCount', 'DESC');
                
        $qb->andWhere('c.status != ?0');
        $qb->setParameter(0, Contribution::DENIED);
        
        if ($type !== null) {
            $qb->andWhere('c.type = ?1');
            $qb->setParameter(1, $type);
        }
        
        return $qb->getQuery()->getResult();
    }
}