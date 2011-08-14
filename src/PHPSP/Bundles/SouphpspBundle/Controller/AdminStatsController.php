<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Prize;
use PHPSP\Bundles\SouphpspBundle\Form\PrizeType;

/**
 * Stats controller.
 *
 * @Route("/souphpsp/admin/stats")
 */
class AdminStatsController extends Controller
{
    /**
     * Lists all Prize entities.
     *
     * @Route("/", name="souphpsp_admin_stats")
     * @Template()
     */
    public function indexAction()
    {
        
    }
    
}