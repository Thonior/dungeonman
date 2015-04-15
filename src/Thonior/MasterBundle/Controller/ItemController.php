<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Item;
use Thonior\MasterBundle\Form\ItemType;
use Thonior\MasterBundle\Form\RateItemType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Item controller.
 *
 * @Route("/item")
 */
class ItemController extends myController
{

    /**
     * Lists all Item entities.
     *
     * @Route("/", name="item")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $universe = $request->getSession()->get('universe');
	$universe = $em->getRepository('ThoniorMasterBundle:Universe')->findOneByName($universe);
        
        $entities = $universe->getItems();
        
        $items = array();
        
        foreach ($entities as $entity){
            $entity->setIsAuthor($this->isAuthor($entity));
            $type = get_class($entity);
            if(strpos($type,'Armor')){
                $entity->setType('armor');
            }
            elseif(strpos($type,'Weapon')){
                $entity->setType('weapon');
            }
            else{
                $entity->setType('item');
            }
            $items[] = $entity;
        }
        $vars = array( 'entities' => $items );

        return $this->template($request,$vars);
    }
    /**
     * Creates a new Item entity.
     *
     * @Route("/", name="item_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Item:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Item();
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
            
            return $this->redirect($this->generateUrl('item_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Item entity.
    *
    * @param Item $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(), $entity, array(
            'action' => $this->generateUrl('item_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Item entity.
     *
     * @Route("/new", name="item_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Item();
        $form   = $this->createCreateForm($entity);
         
        $vars = array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        );
        
        return $this->template($request, $vars);
    }
    
    /**
     * @Route("/creation",name="item_creation")
     * @Method("GET")
     * @Template()
     */
    public function creationAction(Request $request){
        return $this->template($request);
    }
    
    /**
     * Finds and displays a Item entity.
     *
     * @Route("/{id}", name="item_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }
        
        $entity = $this->getTags($entity);
        
        $rateForm = $this->createRateForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $vars = array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'rate_form' => $rateForm->createView(),
        );
        
        return $this->template($request, $vars);
    }
    
    /**
     * Finds and displays a Hero entity.
     *
     * @Route("/viewer", name="item_show_viewer")
     * @Method("POST")
     */
    public function showViewerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $id = $request->request->get('id');
        
        $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);
        $template = 'ThoniorMasterBundle:Item:showViewer.html.twig';
        if($entity->getType() == 'armor'){
            $template = 'ThoniorMasterBundle:Armor:showViewer.html.twig';
        }
        if($entity->getType() == 'weapon'){
            $template = 'ThoniorMasterBundle:Weapon:showViewer.html.twig';
        }
        
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }


        $vars = array(
            'entity' => $entity,
            'basepath' => 'http://localhost/dungeonman/web/',
        );
        return $this->render($template, $vars);
    }
    
    /**
     * Displays a form to edit an existing Item entity.
     *
     * @Route("/{id}/edit", name="item_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
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
    * Creates a form to edit a Item entity.
    *
    * @param Item $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Item $entity)
    {
        $form = $this->createForm(new ItemType(), $entity, array(
            'action' => $this->generateUrl('item_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Item entity.
     *
     * @Route("/{id}", name="item_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Item:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);
            
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $tagman = $this->tag($editForm['tags']->getData(),$entity);
            
            $em->persist($entity);
            $em->flush();
            
            $tagman->saveTagging($entity);

            return $this->redirect($this->generateUrl('item_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Item entity.
     *
     * @Route("/{id}", name="item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Item entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('item'));
    }

    /**
     * Creates a form to delete a Item entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Adds a rate to a item entity
     *
     * @Route("/rate", name="item_rate")
     * @Method("POST")
     */
    public function rateAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $entity = $em->getRepository('ThoniorMasterBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }
        $rateForm = $this->createRateForm($entity);
        $cookies = $request->cookies;
        if($cookies->has('voted_item_'.$id)){
            $stars = $request->request->get('stars');
            
            $entity->setTotalRate($entity->getTotalRate() - $cookies->get('voted_item_'.$id));
            $entity->addTotalRate($stars);
            $rating = $entity->getTotalRate() / $entity->getRates(); 
            $entity->setRating($rating);
            
            $em->persist($entity);
            $em->flush();
            
            $response = new Response();
            $response->setContent('ok');
        }
        else{
            $stars = $request->request->get('stars');
            $entity->addRate();
            $entity->addTotalRate($stars);
            $rating = $entity->getTotalRate() / $entity->getRates(); 
            $entity->setRating($rating);
            
            $em->persist($entity);
            $em->flush();
            
            $response = new Response();
            $response->setContent('ok');
        }
        return $response;
        
    }
    
    /**
    * Creates a form to rate a Item entity.
    *
    * @param Item $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createRateForm(Item $entity)
    {
        $form = $this->createForm(new RateItemType(), $entity, array(
            'action' => $this->generateUrl('item_rate'),
            'method' => 'PUT',
        ));

        return $form;
    }
    
}
