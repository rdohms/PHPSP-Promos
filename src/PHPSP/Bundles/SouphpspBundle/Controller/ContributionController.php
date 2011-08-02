<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * Lists all Contribution entities.
     *
     * @Route("/", name="contribution")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SouphpspBundle:Contribution')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Contribution entity.
     *
     * @Route("/{id}/show", name="contribution_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Contribution')->find($id);

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
        
        //Define logged user id
        $entity->setUserId($this->get('security.context')->getToken()->getUser());
        
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

            //Set Default fields
            $entity->setStatus(Contribution::PENDING);
            $entity->setDateAdded(new \DateTime());
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('contribution_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Contribution entity.
     *
     * @Route("/{id}/edit", name="contribution_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Contribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contribution entity.');
        }

        $editForm = $this->createForm(new ContributionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Contribution entity.
     *
     * @Route("/{id}/update", name="contribution_update")
     * @Method("post")
     * @Template("SouphpspBundle:Contribution:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Contribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contribution entity.');
        }

        $editForm   = $this->createForm(new ContributionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('contribution_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SouphpspBundle:Contribution')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contribution entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contribution'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    protected function createNotListedProject($form, $entity)
    {
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
        $this->getDoctrine()->getEntityManager()->persist($project);

        //Add to project key
        $entity->setProject($project);
    }
    
    protected function selectOtherContributionType($form, $entity)
    {
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
