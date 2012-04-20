<?php

namespace wbx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use wbx\CoreBundle\Entity\Post;
use wbx\AdminBundle\Form\PostType;
use wbx\AdminBundle\Filter\PostFilterType;

/**
 * @Route("/post")
 */
class PostController extends Controller {

    /**
     * @Route("/", name="admin_post")
     * @Template()
     * @return array
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $session = $this->getRequest()->getSession();
        $route_name = $this->container->get('request')->get('_route');

        $queryBuilder = $em->createQueryBuilder()->select('q')->from('wbx\CoreBundle\Entity\Post', 'q');

        $form_filter = $this->get('form.factory')->create(new PostFilterType());

        if ($this->get('request')->getMethod() == 'POST') {
            $filters = $this->get('request')->request->get($form_filter->getName());
            $form_filter->bind($filters);
            $session->set($route_name . '_filters', $filters);
        }
        else {
            if ($this->get('request')->query->get('filter_reset')) {
                $session->set($route_name . '_filters', array());
            }

            $form_filter->bind($session->get($route_name . '_filters'));
        }

        $this->get('lexik_form_filter.query_builder')->buildQuery($form_filter, $queryBuilder);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $this->get('request')->query->get('page', 1),
            10
        );

        return array(
            'pagination'    =>  $pagination,
            'form_filter'   =>  $form_filter->createView()
        );
    }


    /**
     * @Route("/new", name="admin_post_new")
     * @Template()
     * @return array
     */
    public function newAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = new Post();
        $form = $this->createForm(new PostType(), $entity);

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
    }


    /**
     * @Route("/create", name="admin_post_create")
     * @Method("post")
     * @Template("wbxAdminBundle:Post:new.html.twig")
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = new Post();
        $request = $this->getRequest();
        $form = $this->createForm(new PostType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('info', 'Your changes were successfully saved');

            return $this->redirect($this->generateUrl('admin_post'));
        }
        else {
            $this->get('session')->setFlash('error', 'Please correct the errors below');
        }

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
    }


    /**
     * @Route("/{id}/edit", name="admin_post_edit")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('wbxCoreBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->_createDeleteForm($id);

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        );
    }


    /**
     * @Route("/{id}/update", name="admin_post_update")
     * @Method("post")
     * @Template("wbxAdminBundle:Post:edit.html.twig")
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('wbxCoreBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm(new PostType(), $entity);
        $deleteForm = $this->_createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('info', 'Your changes were successfully saved');

            return $this->redirect($this->generateUrl('admin_post'));
        }
        else {
            $this->get('session')->setFlash('error', 'Please correct the errors below');
        }

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        );
    }


    /**
     * @Route("/{id}/delete", name="admin_post_delete")
     * @Method("post")
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id) {
        $form = $this->_createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('wbxCoreBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $this->get('session')->setFlash('info', 'Object successfully deleted');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_post'));
    }


    private function _createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }


    
}
