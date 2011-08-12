<?php

namespace PHPSP\Bundles\SouphpspBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PHPSP\Bundles\SouphpspBundle\Entity\Prize;
use PHPSP\Bundles\SouphpspBundle\Form\PrizeType;

/**
 * Prize controller.
 *
 * @Route("/souphpsp/admin/prize")
 */
class AdminPrizeController extends Controller
{
    /**
     * Lists all Prize entities.
     *
     * @Route("/", name="souphpsp_admin_prize")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('SouphpspBundle:Prize')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Prize entity.
     *
     * @Route("/{id}/show", name="souphpsp_admin_prize_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Prize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prize entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Prize entity.
     *
     * @Route("/new", name="souphpsp_admin_prize_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Prize();
        $form   = $this->createForm(new PrizeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Prize entity.
     *
     * @Route("/create", name="souphpsp_admin_prize_create")
     * @Method("post")
     * @Template("SouphpspBundle:Prize:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Prize();
        $request = $this->getRequest();
        $form    = $this->createForm(new PrizeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('souphpsp_admin_prize_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Prize entity.
     *
     * @Route("/{id}/edit", name="souphpsp_admin_prize_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Prize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prize entity.');
        }

        $editForm = $this->createForm(new PrizeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Prize entity.
     *
     * @Route("/{id}/update", name="souphpsp_admin_prize_update")
     * @Method("post")
     * @Template("SouphpspBundle:Prize:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('SouphpspBundle:Prize')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prize entity.');
        }

        $editForm   = $this->createForm(new PrizeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('souphpsp_admin_prize_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Prize entity.
     *
     * @Route("/{id}/delete", name="souphpsp_admin_prize_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('SouphpspBundle:Prize')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prize entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('souphpsp_admin_prize'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
