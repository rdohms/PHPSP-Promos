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
 * Prize controller.
 *
 * @Route("/souphpsp/admin/contribution")
 */
class AdminContributionController extends Controller
{
    /**
     * Lists all Prize entities.
     *
     * @Route("/{filterStatus}", name="souphpsp_admin_contribution", defaults={"filterStatus" = "2"})
     * @Template()
     */
    public function indexAction($filterStatus = Contribution::PENDING)
    {
        $contribs = $this->getEM()->getRepository('SouphpspBundle:Contribution')->getByStatus($filterStatus);
        
        return array( 'contribs' => $contribs, 'status' => $filterStatus);
    }
    
    /**
     * Edit a contribution
     *
     * @Route("/{id}/edit", name="souphpsp_admin_contribution_edit")
     * @Template()
     */
    public function editAction($id)
    {

        $entity = $this->getEM()->getRepository('SouphpspBundle:Contribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Contribuição não encontrada.');
        }

        $editForm = $this->createForm(new AdminContributionType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $this->createDeleteForm($id)->createView()
        );
    }
    
    /**
     * Update a contribution
     *
     * @Route("/{id}/update", name="souphpsp_admin_contribution_update")
     * @Method("post")
     * @Template()
     */
    public function updateAction($id)
    {
        $entity = $this->getEM()->getRepository('SouphpspBundle:Contribution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contribution entity.');
        }

        $editForm   = $this->createForm(new AdminContributionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {

            $entity->setMentorId( $this->getLoggedUser()->id );
            $entity->setDateRevised( new \DateTime('now') );
            
            $this->getEM()->persist($entity);
            $this->getEM()->flush();

            return $this->redirect($this->generateUrl('souphpsp_admin_contribution', array('filterStatus' => $entity->getStatus())));
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
     * @Route("/{id}/delete", name="souphpsp_admin_contribution_delete")
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

        return $this->redirect($this->generateUrl('souphpsp_admin_contribution'));
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}