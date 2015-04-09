<?php

namespace Thonior\MasterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Thonior\MasterBundle\Entity\Chapter;
use Thonior\MasterBundle\Form\ChapterType;

/**
 * Chapter controller.
 *
 * @Route("/chapter")
 */
class ChapterController extends myController
{

    /**
     * Lists all Chapter entities.
     *
     * @Route("/", name="chapter")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ThoniorMasterBundle:Chapter')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Chapter entity.
     *
     * @Route("/", name="chapter_create")
     * @Method("POST")
     * @Template("ThoniorMasterBundle:Chapter:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Chapter();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $campaign = $em->getRepository('ThoniorMasterBundle:Campaign')->find($this->get('request')->request->get('campaign'));
            
            $entity->setCampaign($campaign);
            $em->persist($entity);
            $em->flush();

            echo $entity->getId();die;
            //return $this->redirect($this->generateUrl('chapter_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'campaign' => $this->get('request')->request->get('campaign'),
        );
    }

    /**
    * Creates a form to create a Chapter entity.
    *
    * @param Chapter $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Chapter $entity)
    {
        $form = $this->createForm(new ChapterType(), $entity, array(
            'action' => $this->generateUrl('chapter_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Chapter entity.
     *
     * @Route("/new/{campaign}", name="chapter_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($campaign)
    {
        $entity = new Chapter();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'campaign' => $campaign,
        );
    }

    /**
     * Finds and displays a Chapter entity.
     *
     * @Route("/{id}", name="chapter_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Chapter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Chapter entity.
     *
     * @Route("/{id}/edit", name="chapter_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Chapter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapter entity.');
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
    * Creates a form to edit a Chapter entity.
    *
    * @param Chapter $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Chapter $entity)
    {
        $form = $this->createForm(new ChapterType(), $entity, array(
            'action' => $this->generateUrl('chapter_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Chapter entity.
     *
     * @Route("/{id}", name="chapter_update")
     * @Method("PUT")
     * @Template("ThoniorMasterBundle:Chapter:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ThoniorMasterBundle:Chapter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chapter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('chapter_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Chapter entity.
     *
     * @Route("/{id}", name="chapter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ThoniorMasterBundle:Chapter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Chapter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('chapter'));
    }

    /**
     * Creates a form to delete a Chapter entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chapter_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
