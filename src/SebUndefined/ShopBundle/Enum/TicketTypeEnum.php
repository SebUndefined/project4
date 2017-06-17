<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 17/06/17
 * Time: 12:45
 */

namespace SebUndefined\ShopBundle\Enum;


abstract class TicketTypeEnum
{
    const TYPE_FULL = "full";
    const TYPE_HALF = "half";

    protected static $typeName = [
        self::TYPE_FULL => 'Journée',
        self::TYPE_HALF => 'Demi-journée'
    ];

    /**
     * @param $typeShort
     * @return string
     */
    public static function getTypeName($typeShort)
    {
        if (!isset(static::$typeName[$typeShort])) {
            return "Unknown type ($typeShort)";
        }

        return static::$typeName[$typeShort];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_FULL,
            self::TYPE_HALF,
        ];
    }
}