<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 20/06/17
 * Time: 13:56
 */

namespace SebUndefined\ShopBundle\Services;

class CheckDate
{
    public function isValidFormat($date) {
        if(preg_match("/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/", $date)) {
            return true;
        }
        else {
            return false;
        }
    }
    public function isNotAtClosedDay($date) {

    }
    public function isNotBefore($date) {

        $today = new \DateTime();
        $interval = $today->diff($date);
        if ($interval->format('%R%a') < 0) {
            return false;
        }
        return true;
    }

    public function checkTypeAndTime ($date, $type) {
        var_dump($date);
        var_dump($type);
        die();
    }
}