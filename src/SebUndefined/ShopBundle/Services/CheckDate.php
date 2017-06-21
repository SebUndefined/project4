<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 20/06/17
 * Time: 13:56
 */

namespace SebUndefined\ShopBundle\Services;

use Doctrine\ORM\EntityManager;
use SebUndefined\ShopBundle\Enum\TicketTypeEnum;

class CheckDate
{
    private $em = null;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function isValidFormat($date) {
        if(preg_match("/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/", $date)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function isNotBefore($date) {

        $today = new \DateTime();
        $interval = $today->diff($date);
        if ($interval->format('%R%a') < 0) {
            return false;
        }
        return $interval->format('%R%a');
    }

    public function checkTypeAndTime ($interval, $type) {
        if ($interval > 0) {
            return true;
        }
        else {
            $hour = new \DateTime();
            $hour = $hour->format('H');
            if ($hour > 14 && $type == TicketTypeEnum::TYPE_FULL) {
                return false;
            }
            else {
                return true;
            }
        }
    }
    public function isNotAtClosedDay($date) {
        if($date->format('D') == 'Tue' ||
            $date->format('D') == 'Sun') {
            return false;
        }
        $dayYear = $date->format('dm');
        if ($dayYear === 0105 || $dayYear === 0111 || $dayYear === 2512) {
            return false;
        }
        return true;
    }
    public function checkIfFull($date, $number) {
        $ticketReserved = $this->em
            ->getRepository('SebUndefinedShopBundle:Ticket')
            ->countTicketForDay($date, $number);
        if ($ticketReserved + $number > 1000) {
            return false;
        }
        return true;

    }
}