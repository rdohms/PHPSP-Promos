<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/souphpsp")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
