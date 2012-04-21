<?php

namespace wbx\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("")
 */
class DefaultController extends Controller {

    /**
     * @Route("", name="index")
     * @Template()
     * @return array
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getEntityManager();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $em->getRepository('wbxCoreBundle:Post')->findAll(),
            $this->get('request')->query->get('page', 1),
            4
        );

        return $this->render('wbxSiteBundle:Default:index.html.twig', array(
            'pagination'    =>  $pagination,
        ));
    }


    /**
     * @Route("post/{slug}", name="post")
     * @Template()
     * @param $slug
     * @return array
     */
    public function postAction($slug) {
        $em = $this->getDoctrine()->getEntityManager();

        if (!$entity = $em->getRepository('wbxCoreBundle:Post')->findOneBySlug($slug)) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return array(
            'entity'  =>  $entity
        );
    }

}
