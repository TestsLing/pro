<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 11:02
 */

namespace App\Models;

use App\Models\Product\ProductInfoModel;
use App\Models\Product\ProductBasicModel;
use App\Models\Product\RelUserProductModel;
use App\Models\Tag\TagModel;
use App\Models\Tag\ProductStyleTagModel;
use App\Models\Letter\LetterModel;
use App\Models\Letter\LetterContentModel;


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

    /**
     * 私信-留言
     * @var LetterModel
     */
    public $letterModel;

    /**
     * 私信-留言-内容
     * @var LetterContentModel
     */
    public $letterContentModel;


    public function __construct(
        ProductBasicModel $productBasicModel,
        ProductInfoModel $productInfoModel,
        ProductStyleTagModel $productStyleTagModel,
        TagModel $tagModel,
        LetterModel $letterModel,
        LetterContentModel $letterContentModel,
        RelUserProductModel $relUserProductModel
    )
    {
        $this->productInfoModel = $productInfoModel;
        $this->productBasicModel = $productBasicModel;
        $this->relUserProductModel = $relUserProductModel;
        $this->tagModel = $tagModel;
        $this->productStyleTagModel = $productStyleTagModel;
        $this->letterModel = $letterModel;
        $this->letterContentModel = $letterContentModel;

    }

}