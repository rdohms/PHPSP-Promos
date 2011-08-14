<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Prize;
use PHPSP\Bundles\SouphpspBundle\Form\PrizeType;
use PHPSP\Bundles\SouphpspBundle\Entity\Contribution;

/**
 * Prize controller.
 *
 * @Route("/souphpsp/admin/contribution")
 */
class AdminContributionController extends Controller
{
    /**
     * Lists all Prize entities.
     *
     * @Route("/{filterStatus}", name="souphpsp_admin_contribution", defaults={"filterStatus" = "2"})
     * @Template()
     */
    public function indexAction($filterStatus = Contribution::PENDING)
    {
        $contribs = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getByStatus($filterStatus);
        
        return array( 'contribs' => $contribs, 'status' => $filterStatus);
    }
    
    /**
     * Edit a contribution
     *
     * @Route("/{id}/edit", name="souphpsp_admin_contribution_edit")
     * @Template()
     */
    public function editAction($id)
    {
        
    }
    
    /**
     * Update a contribution
     *
     * @Route("/{id}/update", name="souphpsp_admin_prize")
     * @Method("post")
     * @Template()
     */
    public function updateAction($id)
    {
        
    }
}