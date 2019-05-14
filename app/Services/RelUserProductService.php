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
     * 获取用户创建的所有产品
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function list(array $param)
    {
        $productBasicModel = self::$model->productBasicModel;
        $relUserProductModel = self::$model->relUserProductModel;
        $productInfoModel = self::$model->productInfoModel;

        $guidArr = $relUserProductModel->where('user_guid', $param['guid'])->get(['product_guid']);

        $productList = $productBasicModel->whereIn('guid', $guidArr)->get();

        return [
            'code' => 200,
            'result' => [
                'list' => $productList
            ]
        ];
    }

}