<?php

namespace Pilote\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PiloteCoreBundle:Default:index.html.twig');
    }
}
