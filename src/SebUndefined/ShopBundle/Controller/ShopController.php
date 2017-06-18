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
use SebUndefined\ShopBundle\Form\HomeType;
use SebUndefined\ShopBundle\Form\OrderMuseumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ShopController extends Controller
{
    public function indexAction(Request $request) {
        $session = $request->getSession();
        $formBuilder = $this->get('form.factory')->createBuilder(HomeType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            $dataForm = $form->getData();
            $session->set('visitDate', $dataForm['visitDate']);
            $session->set('number', $dataForm['number']);
            $session->set('type', $dataForm['type']);
            return $this->redirectToRoute('seb_undefined_shop_order');
        }
        // Form Generation
        return $this->render('SebUndefinedShopBundle:Shop:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function orderAction(Request $request)
    {
        $order = new OrderMuseum();
        $number = $request->getSession()->get('number');
        for ($i=0;$i < $number;$i++)
        {
            $order->addTicket(new Ticket());
        }
        $formBuilder = $this->get('form.factory')->createBuilder(OrderMuseumType::class, $order);
        $form = $formBuilder->getForm();
        return $this->render('SebUndefinedShopBundle:Shop:order.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function trackAction() {
        return $this->render('SebUndefinedShopBundle:Shop:track.html.twig');
    }

}