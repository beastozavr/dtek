<?php

namespace Dtek\SocialProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SocialProjectBundle:Default:index.html.twig', array('name' => $name));
    }
}
