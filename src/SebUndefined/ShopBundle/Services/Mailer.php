<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 03/07/17
 * Time: 21:05
 */

namespace SebUndefined\ShopBundle\Services;


use SebUndefined\ShopBundle\Entity\OrderMuseum;

class Mailer
{

    public function sendEmail(OrderMuseum $order) {
        $message = \Swift_Message::newInstance()
            ->setSubject("Votre commande - Musee du Louvre")
            ->setFrom("no-reply@sebundefined.fr")
            ->setTo($order->getEmail())
            ->setBody("test");
        $this->mailer->send($message);
    }
}