<?php

namespace Bfa\ProgressMonitorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BfaProgressMonitorBundle:Default:index.html.twig');
    }
}
