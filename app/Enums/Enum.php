<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 11:02
 */

namespace App\Enums;


interface Enum
{
    /**
     * 获取对应描述信息
     * @param $value
     * @return mixed
     * @author: 憧憬
     */
    public static function getDescription($value);


}