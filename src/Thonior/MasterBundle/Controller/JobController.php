<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Job;
use Thonior\MasterBundle\Form\JobType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Job controller.
 *
 * @Route("/job")
 */
class JobController extends myController
{

    /**
     * Lists all Job entities.
     *
     * @Route("/", name="job")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
	
	$universe = $request->getSession()->get('universe');
	$universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
	
        $jobs = $universe->getJobs();
        $vars = array ( 'entities' => $jobs );
        
        return $this->template($request, $vars);
    }
    /**
     * Creates a new Job entity.
     *
     * @Route("/", name="job_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Job:new.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Job();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
	    $em = $this->getDoctrine()->getManager();
	    
	    $universe = $request->getSession()->get('universe');
	    $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
	    
	    $entity->setUniverse($universe);
	    
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Job entity.
    *
    * @param Job $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('job_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="job_new")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $entity = new Job();
        $form   = $this->createCreateForm($entity);
        $vars = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}", name="job_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $vars = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="job_edit")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
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
    * Creates a form to edit a Job entity.
    *
    * @param Job $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('job_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Job entity.
     *
     * @Route("/{id}", name="job_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Job:edit.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('job_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}", name="job_delete")
     * @Method("DELETE")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Job')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('job'));
    }

    /**
     * Creates a form to delete a Job entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('job_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
