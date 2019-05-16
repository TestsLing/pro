<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 15:06
 */

namespace App\Enums\Letter;


use App\Enums\Enum;

class LetterReadStatus implements Enum
{

    const NOTREAD = 0;

    const READED = 1;

    public static function getDescription($value)
    {
        switch ($value){
            case self::NOTREAD:
                return '未读';
                break;

            case self::READED:
                return '已读';
                break;

            default:
                return '';
                break;
        }
    }

}