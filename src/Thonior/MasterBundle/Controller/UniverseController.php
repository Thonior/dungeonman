<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Universe;
use Thonior\MasterBundle\Form\UniverseType;

/**
 * Universe controller.
 *
 * @Route("/universe")
 */
class UniverseController extends myController
{

    /**
     * Lists all Universe entities.
     *
     * @Route("/", name="universe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $universes = $em->getRepository('ThoniorMasterBundle:Universe')->findAll();        
        
        $vars = array( 'entites' => $universes);
        
        return $this->template($request, $vars);
        
    }
    /**
     * Creates a new Universe entity.
     *
     * @Route("/", name="universe_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Universe:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Universe();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('universe_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Universe entity.
    *
    * @param Universe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Universe $entity)
    {
        $form = $this->createForm(new UniverseType(), $entity, array(
            'action' => $this->generateUrl('universe_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Universe entity.
     *
     * @Route("/new", name="universe_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Universe();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Universe entity.
     *
     * @Route("/{id}", name="universe_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Universe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Universe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $vars = array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView()
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Displays a form to edit an existing Universe entity.
     *
     * @Route("/{id}/edit", name="universe_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Universe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Universe entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Universe entity.
    *
    * @param Universe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Universe $entity)
    {
        $form = $this->createForm(new UniverseType(), $entity, array(
            'action' => $this->generateUrl('universe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Universe entity.
     *
     * @Route("/{id}", name="universe_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Universe:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Universe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Universe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('universe_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Universe entity.
     *
     * @Route("/{id}", name="universe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Universe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Universe entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('universe'));
    }

    /**
     * Creates a form to delete a Universe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('universe_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
