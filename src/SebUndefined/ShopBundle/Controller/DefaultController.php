<?php

namespace SebUndefined\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SebUndefinedShopBundle:Default:index.html.twig');
    }
}
