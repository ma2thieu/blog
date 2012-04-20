<?php

namespace wbx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use wbx\CoreBundle\Entity\Author;
use wbx\AdminBundle\Form\AuthorType;
use wbx\AdminBundle\Filter\AuthorFilterType;

/**
 * @Route("/author")
 */
class AuthorController extends Controller {

    /**
     * @Route("/", name="admin_author")
     * @Template()
     * @return array
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $session = $this->getRequest()->getSession();
        $route_name = $this->container->get('request')->get('_route');

        $queryBuilder = $em->createQueryBuilder()->select('q')->from('wbx\CoreBundle\Entity\Author', 'q');

        $form_filter = $this->get('form.factory')->create(new AuthorFilterType());

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
     * @Route("/new", name="admin_author_new")
     * @Template()
     * @return array
     */
    public function newAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = new Author();
        $form = $this->createForm(new AuthorType(), $entity);

        return array(
            'entity'    => $entity,
            'form'      => $form->createView(),
        );
    }


    /**
     * @Route("/create", name="admin_author_create")
     * @Method("post")
     * @Template("wbxAdminBundle:Author:new.html.twig")
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = new Author();
        $request = $this->getRequest();
        $form = $this->createForm(new AuthorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('info', 'Your changes were successfully saved');

            return $this->redirect($this->generateUrl('admin_author'));
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
     * @Route("/{id}/edit", name="admin_author_edit")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('wbxCoreBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $editForm = $this->createForm(new AuthorType(), $entity);
        $deleteForm = $this->_createDeleteForm($id);

        return array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        );
    }


    /**
     * @Route("/{id}/update", name="admin_author_update")
     * @Method("post")
     * @Template("wbxAdminBundle:Author:edit.html.twig")
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('wbxCoreBundle:Author')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Author entity.');
        }

        $editForm = $this->createForm(new AuthorType(), $entity);
        $deleteForm = $this->_createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('info', 'Your changes were successfully saved');

            return $this->redirect($this->generateUrl('admin_author'));
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
     * @Route("/{id}/delete", name="admin_author_delete")
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
            $entity = $em->getRepository('wbxCoreBundle:Author')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Author entity.');
            }

            $this->get('session')->setFlash('info', 'Object successfully deleted');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_author'));
    }


    private function _createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }


    
}
