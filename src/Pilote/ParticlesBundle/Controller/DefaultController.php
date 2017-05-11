<?php

namespace Pilote\ParticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PiloteParticlesBundle:Default:index.html.twig');
    }
}
