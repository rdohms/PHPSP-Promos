<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use PHPSP\Controller\Controller;
use Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Contribution;
use PHPSP\Bundles\SouphpspBundle\Form\ContributionType;
use PHPSP\Bundles\SouphpspBundle\Entity\Project;


/**
 * Contribution controller.
 *
 * @Route("/souphpsp/contribution")
 */
class ContributionController extends Controller
{

    /**
     * Lists all Contribution entities by this user.
     *
     * @Route("/", name="contribution")
     * @Template()
     */
    public function indexAction()
    {
        $uid = $this->getLoggedUser()->id;

        $entities = $this->getEM()->getRepository('SouphpspBundle:Contribution')->findMyContributions($uid);

        $contributions = array( array(), array(), array() );
        foreach($entities as $contribution){
            $contributions[$contribution->getStatus()][] = $contribution;
        }
        
        return array('entities' => $contributions);
    }

    /**
     * Finds and displays a Contribution entity.
     *
     * @Route("/{id}/show", name="contribution_show")
     * @Template()
     */
    public function showAction($id)
    {

        $entity = $this->getEM()->getRepository('SouphpspBundle:Contribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contribution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        
        );
    }

    /**
     * Displays a form to create a new Contribution entity.
     *
     * @Route("/new", name="contribution_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contribution();
        
        $form   = $this->createForm(new ContributionType(), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Contribution entity.
     *
     * @Route("/create", name="contribution_create")
     * @Method("post")
     * @Template("SouphpspBundle:Contribution:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Contribution();
        $request = $this->getRequest();
        $form    = $this->createForm(new ContributionType(), $entity);
        $form->bindRequest($request);

        $this->createNotListedProject($form, $entity);
        
        if ($form->isValid()) {

            //Update UserId
            $entity->setUserId($this->getLoggedUser()->id);
            
            //Set Default fields
            $entity->setStatus(Contribution::PENDING);
            $entity->setDateAdded(new \DateTime('now'));
            
            $this->getEM()->persist($entity);
            $this->getEM()->flush();
            
            // Mail para Admin
            $message = \Swift_Message::newInstance()
                ->setSubject('[Sou PHPSP] Nova contribuição')
                ->setFrom('noreply@phpsp.org.br')
                ->setTo(/* read from config */)
                ->setBody($this->renderView('SouphpspBundle:Email:new_contribution.txt.twig', array('contribution' => $entity)));
            $this->get('mailer')->send($message);
            
            return $this->redirect($this->generateUrl('contribution_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Deletes a Contribution entity.
     *
     * @Route("/{id}/delete", name="contribution_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $entity = $this->getEM()->getRepository('SouphpspBundle:Contribution')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contribution entity.');
            }
            
            //Only the owner
            if ($entity->getUserId() !== $this->getLoggedUser()->id) {
                throw new Exception("You cannot delete this entity");
            }
            
            //Only if pending
            if ($entity->getStatus() !== Contribution::PENDING) {
                throw new Exception("You cannot delete this entity");
            }

            $this->getEM()->remove($entity);
            $this->getEM()->flush();
        }

        return $this->redirect($this->generateUrl('contribution'));
    }

    /**
     * Creates a simple for for delete button
     * 
     * @param int $id
     * @return Symfony\Component\Form\Form 
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Creates a new project based on "other" inputed by the user
     * 
     * @param Symfony\Component\Form\Form $form
     * @param Contribution $entity
     */
    protected function createNotListedProject($form, $entity)
    {
        //See if a project was selected
        if ($form->get('project')->getData() !== null) {
            return;
        }
        
        //Get 'other'project
        $projectName = $form->get('projectOther')->getData();
            
        //Validate
        if ($projectName === null) $form->addError(new FormError('Selecione um projeto ou forneça um não listado'));
           
        //Create new Project
        $project = new Project();
        $project->setName($projectName);
        $project->setStatus(Project::STATUS_PENDING);
        $this->getEM()->persist($project);

        //Add to project key
        $entity->setProject($project);
    }
    
    /**
     * Adds a new Contribution Type
     * 
     * @param Symfony\Component\Form\Form $form
     * @param Contribution $entity
     */
    protected function selectOtherContributionType($form, $entity)
    {
        // Check that no type selected
        if ($form->get('type')->getData() !== 'Outro') {
            return;
        }
        
        //Get 'other' type
        $otherType = $form->get('typeOther')->getData();
        
        //Validate
        if ($projectName === null) $form->addError(new FormError('Selecione um tipo de contribuição ou forneça um não listado'));
        
        //Define
        $entity->setType( $otherType );
    }
    
}
