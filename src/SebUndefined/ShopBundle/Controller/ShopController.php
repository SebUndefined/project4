<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 15/06/17
 * Time: 09:35
 */

namespace SebUndefined\ShopBundle\Controller;


use SebUndefined\ShopBundle\Entity\OrderMuseum;
use SebUndefined\ShopBundle\Entity\Ticket;
use SebUndefined\ShopBundle\Form\OrderMuseumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function indexAction(Request $request) {
        $formBuilder = $this->get('form.factory')->createBuilder(OrderMuseumType::class);
        if ($request->isMethod('POST')) {
            die(var_dump("Prout"));
        }
        // Form Generation
        $form = $formBuilder->getForm();
        return $this->render('SebUndefinedShopBundle:Shop:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function trackAction() {
        return $this->render('SebUndefinedShopBundle:Shop:track.html.twig');
    }
}