<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 10:33
 */

namespace App\Enums\Tag;

use App\Enums\Enum;

final class ProductStyleTagStatus implements Enum
{
    const PROHIBIT = 9;

    const ACTIVATED = 1;

    public static function getDescription($value)
    {
        switch ($value){
            case self::PROHIBIT:
                    return '禁用';
                break;

            case self::ACTIVATED:
                    return '启用';
                break;

            default:
                    return '';
                break;
        }
    }


}