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

    /**
     * 产品特色标签
     * @var ProductStyleTagModel
     */
    public $productStyleTagModel;

    /**
     * 基础标签
     * @var TagModel
     */
    public $tagModel;


    public function __construct(
        ProductBasicModel $productBasicModel,
        ProductInfoModel $productInfoModel,
        ProductStyleTagModel $productStyleTagModel,
        TagModel $tagModel,
        RelUserProductModel $relUserProductModel
    )
    {
        $this->productInfoModel = $productInfoModel;
        $this->productBasicModel = $productBasicModel;
        $this->relUserProductModel = $relUserProductModel;
        $this->tagModel = $tagModel;
        $this->productStyleTagModel = $productStyleTagModel;

    }

}