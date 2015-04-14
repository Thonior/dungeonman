<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Armor;
use Thonior\MasterBundle\Form\ArmorType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Armor controller.
 *
 * @Route("/armor")
 */
class ArmorController extends myController
{

    /**
     * Lists all Armor entities.
     *
     * @Route("/", name="armor")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ThoniorMasterBundle:Armor')->findAll();
        
        $vars = array(
            'entities' => $entities,
        );
        
        return $this->template($request, $vars);
    }
    /**
     * Creates a new Armor entity.
     *
     * @Route("/", name="armor_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Armor:new.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Armor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            
            $universe = $request->getSession()->get('universe');
	    $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
            
            $entity->setAuthor($user);
            $entity->setUniverse($universe);
            
            $tagman = $this->tag($form['tags']->getData(),$entity);
            
            $em->persist($entity);
            $em->flush();
            
            $tagman->saveTagging($entity);

            return $this->redirect($this->generateUrl('armor_show', array('id' => $entity->getId())));
        }
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Armor entity.
    *
    * @param Armor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Armor $entity)
    {
        $form = $this->createForm(new ArmorType(), $entity, array(
            'action' => $this->generateUrl('armor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Armor entity.
     *
     * @Route("/new", name="armor_new")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function newAction()
    {
        $entity = new Armor();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Armor entity.
     *
     * @Route("/{id}", name="armor_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Armor')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Armor entity.');
        }
        
        $entity = $this->getTags($entity);

        $deleteForm = $this->createDeleteForm($id);

        $vars = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Displays a form to edit an existing Armor entity.
     *
     * @Route("/{id}/edit", name="armor_edit")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Armor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Armor entity.');
        }

        $entity = $this->getSerializedTags($entity);
        
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
    * Creates a form to edit a Armor entity.
    *
    * @param Armor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Armor $entity)
    {
        $form = $this->createForm(new ArmorType(), $entity, array(
            'action' => $this->generateUrl('armor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Armor entity.
     *
     * @Route("/{id}", name="armor_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Armor:edit.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Armor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Armor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $tagman = $this->tag($editForm['tags']->getData(),$entity);
            
            $em->persist($entity);
            $em->flush();
            
            $tagman->saveTagging($entity);

            return $this->redirect($this->generateUrl('armor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Armor entity.
     *
     * @Route("/{id}", name="armor_delete")
     * @Method("DELETE")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Armor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Armor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('armor'));
    }

    /**
     * Creates a form to delete a Armor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('armor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
