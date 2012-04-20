<?php

namespace wbx\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("")
 */
class DefaultController extends Controller {

    /**
     * @Route("", name="admin")
     * @Template()
     * @return array
     */
    public function indexAction() {
        return array();
    }

}
