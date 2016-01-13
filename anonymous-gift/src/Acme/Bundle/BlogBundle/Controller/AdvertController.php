<?php

namespace Acme\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    $content = $this->get('templating')->render('AcmeBlogBundle:Advert:index.html.twig');
    return new Response($content);
}
}

