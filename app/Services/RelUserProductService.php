<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-14
 * Time: 11:38
 */

namespace App\Services;

use Exception;

class RelUserProductService
{
    protected static $model;

    public function __construct()
    {
        self::$model = app('model');
    }


    /**
     * 创建基本信息
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function create(array $param)
    {

        return [
            'code' => 200,
            'result' => [
                'info' => '添加产品信息成功'
            ]
        ];
    }

}