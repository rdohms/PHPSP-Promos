<?php

namespace PHPSP\Bundles\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthenticationController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction($name)
    {
        return array('name' => $name);
    }

}
