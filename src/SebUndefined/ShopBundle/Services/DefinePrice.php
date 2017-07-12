<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 22/06/17
 * Time: 12:10
 */

namespace SebUndefined\ShopBundle\Services;


class DefinePrice
{
    public function definePriceTicket ($birtdate, $type, $discountTicket) {
        if ($discountTicket === true) {
            $price = 10;
        }
        else {
            $age = $birtdate->diff(new \DateTime('now'))->y;
            if ($age < 4) {
                $price = 0;
            } elseif ($age >= 4 && $age < 12) {
                $price = 8;
            }
            elseif ($age > 12 && $age < 60) {
                $price = 16;
            } else {
                $price = 12;
            }
        }
        if ($type == "half") {
            $price = $price / 2;
        }
        return $price;
    }
}