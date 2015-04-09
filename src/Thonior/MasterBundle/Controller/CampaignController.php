<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Campaign;
use Thonior\MasterBundle\Form\CampaignType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Campaign controller.
 *
 * @Route("/campaign")
 */
class CampaignController extends myController
{

    /**
     * Lists all Campaign entities.
     *
     * @Route("/", name="campaign")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $universe = $request->getSession()->get('universe');
	$universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
        
        $entities = $universe->getCampaigns();
        
        $campaigns = array();
        
        foreach ($entities as $entity){
            $entity->setIsAuthor($this->isAuthor($entity));
            $campaigns[] = $entity;
        }
        $vars = array('entities' => $campaigns);
        
        return $this->template($request,$vars);
    }
    /**
     * Creates a new Campaign entity.
     *
     * @Route("/", name="campaign_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Campaign:new.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        
        $entity = new Campaign();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            
            $universe = $request->getSession()->get('universe');
	    $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
            
            $entity->setAuthor($user);
            $entity->setRating(0);
            $entity->setUniverse($universe);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('campaign_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Campaign entity.
    *
    * @param Campaign $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Campaign $entity)
    {
        $form = $this->createForm(new CampaignType(), $entity, array(
            'action' => $this->generateUrl('campaign_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Campaign entity.
     *
     * @Route("/new", name="campaign_new")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $entity = new Campaign();
        $form   = $this->createCreateForm($entity);
        
        $vars = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Finds and displays a Campaign entity.
     *
     * @Route("/{id}", name="campaign_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Campaign')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campaign entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $vars = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Displays a form to edit an existing Campaign entity.
     *
     * @Route("/{id}/edit", name="campaign_edit")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Campaign')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campaign entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $vars = array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
    * Creates a form to edit a Campaign entity.
    *
    * @param Campaign $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Campaign $entity)
    {
        $form = $this->createForm(new CampaignType(), $entity, array(
            'action' => $this->generateUrl('campaign_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Campaign entity.
     *
     * @Route("/{id}", name="campaign_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Campaign:edit.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Campaign')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Campaign entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('campaign_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Campaign entity.
     *
     * @Route("/{id}", name="campaign_delete")
     * @Method("DELETE")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Campaign')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Campaign entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('campaign'));
    }

    /**
     * Creates a form to delete a Campaign entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campaign_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
