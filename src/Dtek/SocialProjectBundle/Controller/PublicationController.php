<?php

namespace Dtek\SocialProjectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Dtek\SocialProjectBundle\Entity\Publication;
use Dtek\SocialProjectBundle\Form\PublicationType;

/**
 * Publication controller.
 *
 */
class PublicationController extends Controller
{

    /**
     * Lists all Publication entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SocialProjectBundle:Publication')->findAll();

        return $this->render('SocialProjectBundle:Publication:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Publication entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Publication();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publication_show', array('id' => $entity->getId())));
        }

        return $this->render('SocialProjectBundle:Publication:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Publication entity.
    *
    * @param Publication $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Publication $entity)
    {
        $form = $this->createForm(new PublicationType(), $entity, array(
            'action' => $this->generateUrl('publication_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Publication entity.
     *
     */
    public function newAction()
    {
        $entity = new Publication();
        $form   = $this->createCreateForm($entity);

        return $this->render('SocialProjectBundle:Publication:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Publication entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialProjectBundle:Publication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SocialProjectBundle:Publication:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Publication entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialProjectBundle:Publication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SocialProjectBundle:Publication:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Publication entity.
    *
    * @param Publication $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Publication $entity)
    {
        $form = $this->createForm(new PublicationType(), $entity, array(
            'action' => $this->generateUrl('publication_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Publication entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SocialProjectBundle:Publication')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publication entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('publication_edit', array('id' => $id)));
        }

        return $this->render('SocialProjectBundle:Publication:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Publication entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SocialProjectBundle:Publication')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publication entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publication'));
    }

    /**
     * Creates a form to delete a Publication entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publication_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
