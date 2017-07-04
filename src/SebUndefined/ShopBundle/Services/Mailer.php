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


    public function sendEmail(OrderMuseum $order, \Swift_Mailer $mailer) {
        $message = new \Swift_Message("Sujet");
        $message->setFrom("louvreproject4@gmail.com");
        $message->setTo($order->getEmail());
        $message->setBody("testdemail");

        $mailer->send($message);
    }
}