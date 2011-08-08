<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Project;
use PHPSP\Bundles\SouphpspBundle\Form\ProjectType;

/**
 * About controller.
 *
 * @Route("/souphpsp/about")
 */
class AboutController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }
    
    /**
     * @Route("/projects")
     * @Template()
     */
    public function projectsAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $projects = $em->getRepository('SouphpspBundle:Project')->getActiveProjects();
        
        return array('projects' => $projects);
    }
    
    /**
     * @Route("/sponsors", name="project")
     * @Template()
     */
    public function sponsorsAction()
    {
        $sponsors = $this->getEM()->getRepository('SouphpspBundle:Sponsor')->getSponsorsInOrder();
        
        return array('sponsors' => $sponsors);
    }

    
}
