<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Contribution;
use PHPSP\Bundles\SouphpspBundle\Form\ContributionType;
use PHPSP\Bundles\SouphpspBundle\Form\AdminContributionType;

/**
 * Admin controller.
 *
 * @Route("/souphpsp/admin")
 */
class AdminController extends Controller
{
    /**
     * Lists all Prize entities.
     *
     * @Route("/", name="souphpsp_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}