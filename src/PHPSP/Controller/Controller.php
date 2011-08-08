<?php

namespace PHPSP\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Project;
use PHPSP\Bundles\SouphpspBundle\Form\ProjectType;


abstract class Controller extends SymfonyController
{
    /**
     * @return Doctrine\ORM\EntityManager 
     */
    public function getEM()
    {
        return $this->getDoctrine()->getEntityManager();
    }
   
    /**
     * Retrieve data for logged in User
     * 
     * @return stdClass
     */
    protected function getLoggedUser()
    {
        $token = $this->get('security.context')->getToken();
        
        if ($token === null) return null;
        if ($token->isAuthenticated() === false) return null;
        
        $uid = $token->getUser();
            
        //Get Twitter Infor
        $twApi = $this->get('phpsp.twitter.api');
        $userData = $twApi->usersShow($uid);
        
        return $userData;
            
    }
    
    
}