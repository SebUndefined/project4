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
        //get all values in the session
        $date = $request->getSession()->get('visitDate');
        $number = $request->getSession()->get('number');
        $type = $request->getSession()->get('type');

        $checkDateService = $this->container->get('seb_undefined_shop.services.check_date');
        $checkDateService->isValidFormat($date);
        //If to do
        $dateFormated = \DateTime::createFromFormat('d/m/Y', $date);
        //Check if the date is not before today
        $interval = $checkDateService->isNotBefore($dateFormated);
        if($interval == false)
        {
            $request->getSession()->getFlashBag()->add('error', 'Vous ne pouvez réserver pour une date antérieur');
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }
        //Check if the Time is ok for full day tickets
        if(!$checkDateService->checkTypeAndTime($interval, $type)) {
            $request->getSession()->getFlashBag()->add('error', 'Vous ne pouvez réserver un billet "journée" après 14 heure');
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }
        //Check if the date is not a free or closed day
        if(!$checkDateService->isNotAtClosedDay($dateFormated)) {
            $request->getSession()->getFlashBag()->add('error', 'Vous ne pouvez réserver un billet ce jour, merci de 
            vérifier les jours disponibles.');
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }
        //Check if the museum is full
        if (!$checkDateService->checkIfFull($dateFormated, $number)) {
            $request->getSession()->getFlashBag()->add('error', 'Pas assez de place disponible pour ce jour');
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }

        $order = new OrderMuseum();
        $number = $request->getSession()->get('number');


        $formBuilder = $this->get('form.factory')->createBuilder(OrderMuseumType::class, $order);
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            for ($i=0;$i < $number;$i++)
            {
                $order->getTickets()->get($i)->setDay($dateFormated);
                $order->getTickets()->get($i)->setType($type);
                $order->getTickets()->get($i)->setPrice(100);
                $order->setPrice(2);
            }
            var_dump($order->getTickets());
            var_dump($order);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                return $this->redirectToRoute('seb_undefined_shop_checkout');
            }
        }
        return $this->render('SebUndefinedShopBundle:Shop:order.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function checkOutAction () {

    }
    public function trackAction() {
        return $this->render('SebUndefinedShopBundle:Shop:track.html.twig');
    }

}