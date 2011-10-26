<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Challenge;
use PHPSP\Bundles\SouphpspBundle\Form\ChallengeType;

/**
 * Challenge controller.
 *
 * @Route("/souphpsp/admin/challenge")
 */
class AdminChallengeController extends Controller
{
    /**
     * Lists all Challenge entities.
     *
     * @Route("/", name="admin_challenge")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SouphpspBundle:Challenge')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Challenge entity.
     *
     * @Route("/{id}/show", name="admin_challenge_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Challenge entity.
     *
     * @Route("/new", name="admin_challenge_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Challenge();
        $form   = $this->createForm(new ChallengeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Challenge entity.
     *
     * @Route("/create", name="admin_challenge_create")
     * @Method("post")
     * @Template("SouphpspBundle:Challenge:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Challenge();
        $request = $this->getRequest();
        $form    = $this->createForm(new ChallengeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            //TODO: Send tweet about challenge
            
            return $this->redirect($this->generateUrl('admin_challenge_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Challenge entity.
     *
     * @Route("/{id}/edit", name="admin_challenge_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $editForm = $this->createForm(new ChallengeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Challenge entity.
     *
     * @Route("/{id}/update", name="admin_challenge_update")
     * @Method("post")
     * @Template("SouphpspBundle:Challenge:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $editForm   = $this->createForm(new ChallengeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_challenge_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Challenge entity.
     *
     * @Route("/{id}/delete", name="admin_challenge_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SouphpspBundle:Challenge')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Challenge entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_challenge'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    //TODO: action to tweet winners
}
