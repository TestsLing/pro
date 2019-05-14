<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 11:02
 */

namespace App\Models;

class Model
{
    /**
     * 产品详情
     * @var ProductInfoModel
     */
    public $productInfoModel;

    /**
     * 产品基本信息
     * @var ProductBasicModel
     */
    public $productBasicModel;

    /**
     * 用户产品关联表
     * @var RelUserProductModel
     */
    public $relUserProductModel;


    public function __construct(
        ProductBasicModel $productBasicModel,
        ProductInfoModel $productInfoModel,
        RelUserProductModel $relUserProductModel
    )
    {
        $this->productInfoModel = $productInfoModel;
        $this->productBasicModel = $productBasicModel;
        $this->relUserProductModel = $relUserProductModel;
    }

}