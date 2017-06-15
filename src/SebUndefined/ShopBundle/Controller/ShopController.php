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
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{

    public function indexAction() {
        $order = new OrderMuseum();
        $form = $this->createForm(OrderMuseumType::class, $order);
        return $this->render('SebUndefinedShopBundle:Shop:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function trackAction() {
        return $this->render('SebUndefinedShopBundle:Shop:track.html.twig');
    }
}