<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 03/07/17
 * Time: 21:05
 */

namespace SebUndefined\ShopBundle\Services;


use SebUndefined\ShopBundle\Entity\OrderMuseum;
use Symfony\Component\Templating\EngineInterface;

class Mailer
{
    private $mailer;
    private  $templating;


    /**
     * Mailer constructor.
     * @param \Swift_Mailer $mailer
     * @param EngineInterface $templating
     */
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;

    }

    /**
     * @param OrderMuseum $order
     */
    public function sendEmail(OrderMuseum $order) {
        $message = new \Swift_Message("Sujet");
        $message->setFrom("louvreproject4@gmail.com");
        $message->setTo($order->getEmail());
        $message->setSubject("Musée du Louvre - Votre Commande");
        $message->setBody(
            $this->templating->render(
                '@SebUndefinedShop/Shop/email.html.twig',
                array('order', $order))
        );
        $message->setContentType('text/html');

        $this->mailer->send($message);
    }
}