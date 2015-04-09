<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Weapon;
use Thonior\MasterBundle\Form\WeaponType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Weapon controller.
 *
 * @Route("/weapon")
 */
class WeaponController extends myController
{

    /**
     * Lists all Weapon entities.
     *
     * @Route("/", name="weapon")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ThoniorMasterBundle:Weapon')->findAll();

        $vars = array(
            'entities' => $entities,
        );
        
        return $this->template($request, $vars);
    }
    /**
     * Creates a new Weapon entity.
     *
     * @Route("/", name="weapon_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Weapon:new.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Weapon();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            
            $universe = $request->getSession()->get('universe');
	    $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
            
            $entity->setAuthor($user);
            $entity->setUniverse($universe);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('weapon_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Weapon entity.
    *
    * @param Weapon $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Weapon $entity)
    {
        $form = $this->createForm(new WeaponType(), $entity, array(
            'action' => $this->generateUrl('weapon_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Weapon entity.
     *
     * @Route("/new", name="weapon_new")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function newAction()
    {
        $entity = new Weapon();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Weapon entity.
     *
     * @Route("/{id}", name="weapon_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Weapon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weapon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $vars = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Displays a form to edit an existing Weapon entity.
     *
     * @Route("/{id}/edit", name="weapon_edit")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Weapon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weapon entity.');
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
    * Creates a form to edit a Weapon entity.
    *
    * @param Weapon $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Weapon $entity)
    {
        $form = $this->createForm(new WeaponType(), $entity, array(
            'action' => $this->generateUrl('weapon_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Weapon entity.
     *
     * @Route("/{id}", name="weapon_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Weapon:edit.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Weapon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weapon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('weapon_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Weapon entity.
     *
     * @Route("/{id}", name="weapon_delete")
     * @Method("DELETE")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Weapon')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Weapon entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('weapon'));
    }

    /**
     * Creates a form to delete a Weapon entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('weapon_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
