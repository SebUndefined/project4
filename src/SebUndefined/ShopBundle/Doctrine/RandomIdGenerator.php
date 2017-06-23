<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 22/06/17
 * Time: 11:41
 */

namespace SebUndefined\ShopBundle\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class RandomIdGenerator extends AbstractIdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        $id = "";
        $char = array_merge(range('A', 'Z'),range('a', 'z'), range('0', '9'));
        $max = count($char) -1;
        for ($i = 0; $i < 12; $i++) {
            $randomNumber = mt_rand(0, $max);
            $id .= $char[$randomNumber];
        }
        return $id;
    }
}