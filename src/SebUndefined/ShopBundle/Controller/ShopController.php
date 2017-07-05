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
use SebUndefined\ShopBundle\Stripe\ConfigStripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;
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
            if ($form->isValid()) {
                $dataForm = $form->getData();
                $visitDate = $dataForm['visitDate'];
                $number = $dataForm['number'];
                $type = $dataForm['type'];
                $checkDateService = $this->container->get('seb_undefined_shop.services.check_date');
                if (!$checkDateService->isValidFormat($visitDate)) {
                    $request->getSession()->getFlashBag()->add('error', 'Format de date invalide');
                    return $this->redirectToRoute('seb_undefined_shop_homepage');
                }
                $dateFormated = \DateTime::createFromFormat('d/m/Y', $visitDate);
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
                if ($number < 1 || $number > 50) {
                    $request->getSession()->getFlashBag()->add('error', 'Impossible de commander ce nombre de billet');
                    return $this->redirectToRoute('seb_undefined_shop_homepage');
                }
                $session->set('visitDate', $dateFormated);
                $session->set('number', $dataForm['number']);
                $session->set('type', $dataForm['type']);
                return $this->redirectToRoute('seb_undefined_shop_order');
            }
        }
        // Form Generation
        return $this->render('SebUndefinedShopBundle:Shop:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function orderAction(Request $request)
    {
        //get all values in the session
        $dateFormated = $request->getSession()->get('visitDate');
        $number = $request->getSession()->get('number');
        $type = $request->getSession()->get('type');
        //Create new Order
        $order = new OrderMuseum();
        for ($i=0;$i < $number;$i++)
        {
            $ticket = new Ticket();
            $ticket->setDay($dateFormated);
            $ticket->setType($type);
            $ticket->setOrderMuseum($order);
            $order->addTicket($ticket);
        }

        $formBuilder = $this->get('form.factory')->createBuilder(OrderMuseumType::class, $order);
        $form = $formBuilder->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            for ($i=0;$i < $number;$i++)
            {
                $order->getTickets()
                    ->get($i)
                    ->setPrice(
                        $this->container->get('seb_undefined_shop.services.define_price')
                            ->definePriceTicket(
                                $order->getTickets()
                                ->get($i)->getBirthdate(),
                                $type,
                                $order->getTickets()
                                ->get($i)->getDiscountTicket())
                    );
            }
            $order->setPrice($order->getPrice());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();
                $request->getSession()->set('orderNumber', $order->getId());
                return $this->redirectToRoute('seb_undefined_shop_checkout');
            }

        }
        return $this->render('SebUndefinedShopBundle:Shop:order.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function checkOutAction (Request $request) {
        if( !$request->getSession()->get('orderNumber')) {
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }
        $orderNumber = $request->getSession()->get('orderNumber');
        $repo = $this->getDoctrine()->getManager()->getRepository('SebUndefinedShopBundle:OrderMuseum');
        $order = $repo->find($orderNumber);

        return $this->render('@SebUndefinedShop/Shop/checkout.html.twig', array(
            'order' => $order,
        ));
    }

    public function finalAction(Request $request) {
        if( !$request->getSession()->get('orderNumber')) {
            return $this->redirectToRoute('seb_undefined_shop_homepage');
        }
        $orderNumber = $request->getSession()->get('orderNumber');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('SebUndefinedShopBundle:OrderMuseum');
        $order = $repo->find($orderNumber);

        $stripeConfig = new ConfigStripe();
        Stripe::setApiKey($stripeConfig->getPrivKey());
        $theToken = $_POST['stripeToken'];
        $email = $_POST['stripeEmail'];
        $customer = Customer::create(array(
            'email'=> $email,
            'source' => $theToken
        ));
        try {
            Charge::create(array(
                'customer' =>$customer->id,
                'amount' => $order->getPrice() * 100,
                'currency' => 'eur'
            ));
            $serviceMail = $this->get("seb_undefined_shop.services.mailer");
            $order->setComplete(true);
            $em->flush();
            $serviceMail->sendEmail($order, $this->get('mailer'));
            $request->getSession()->remove("orderNumber");
            return $this->render('@SebUndefinedShop/Shop/final.html.twig');
        }catch (Card $exception) {
            return "nope...";
        }
    }
    public function trackAction() {
        return $this->render('SebUndefinedShopBundle:Shop:track.html.twig');
    }

}