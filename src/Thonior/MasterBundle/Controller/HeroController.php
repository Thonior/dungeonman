<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Hero;
use Thonior\MasterBundle\Form\HeroType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Hero controller.
 *
 * @Route("/hero")
 */
class HeroController extends myController
{

    /**
     * Lists all Hero entities.
     *
     * @Route("/", name="hero")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $universe = $request->getSession()->get('universe');
	$universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
	
        $entities = $universe->getHeroes();
        
        $heroes = array();
        
        foreach ($entities as $entity){
            $entity->setIsAuthor($this->isAuthor($entity));
            $heroes[] = $entity;
        }
        $vars = array( 'entities' => $heroes);
        
        return $this->template($request,$vars);
    }
    /**
     * Creates a new Hero entity.
     *
     * @Route("/", name="hero_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Hero:new.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Hero();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            
            $universe = $request->getSession()->get('universe');
	    $universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
	    
	    $entity->setUniverse($universe);
            $entity->setAuthor($user);
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('hero_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Hero entity.
    *
    * @param Hero $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Hero $entity)
    {
        $form = $this->createForm(new HeroType(), $entity, array(
            'action' => $this->generateUrl('hero_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Hero entity.
     *
     * @Route("/new", name="hero_new")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $entity = new Hero();
        $form   = $this->createCreateForm($entity);
        $vars = array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
     * Finds and displays a Hero entity.
     *
     * @Route("/{id}", name="hero_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Hero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $vars = array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView()
        );
        
        return $this->template($request,$vars);
    }

    /**
     * Displays a form to edit an existing Hero entity.
     *
     * @Route("/{id}/edit", name="hero_edit")
     * @Method("GET")
     * @Template()
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Hero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hero entity.');
        }
        
        if (!$this->isAuthor($entity)){
            return $this->redirect($this->generateUrl('nopermission'));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        $vars = array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        
        return $this->template($request, $vars);
    }

    /**
    * Creates a form to edit a Hero entity.
    *
    * @param Hero $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Hero $entity)
    {
        $form = $this->createForm(new HeroType(), $entity, array(
            'action' => $this->generateUrl('hero_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Hero entity.
     *
     * @Route("/{id}", name="hero_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Hero:edit.html.twig")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Hero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Hero entity.');
        }
        
        if (!$this->isAuthor($entity)){
            return $this->redirect($this->generateUrl('nopermission'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('hero_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Hero entity.
     *
     * @Route("/{id}", name="hero_delete")
     * @Method("DELETE")
     * @PreAuthorize("hasRole('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Hero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Hero entity.');
            }
            
            if (!$this->isAuthor($entity)){
                return $this->redirect($this->generateUrl('nopermission'));
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('hero'));
    }

    /**
     * Creates a form to delete a Hero entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hero_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
