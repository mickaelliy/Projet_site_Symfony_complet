<?php

namespace Mickweb\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function pageAction()
    {
        return $this->render('MickwebPagesBundle:Default:page.html.twig');
    }
}
