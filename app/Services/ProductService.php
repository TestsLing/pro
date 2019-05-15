<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-14
 * Time: 10:12
 */

namespace App\Services;

use App\Http\Resources\ProductDetailResource;
use App\Tools\Common;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    protected static $model;
    protected static $relUserProductService;

    public function __construct(
        RelUserProductService $relUserProductService
    )
    {
        self::$model = app('model');
        self::$relUserProductService = $relUserProductService;
    }

    /**
     * 添加产品
     * @param array $param
     * @return array
     * @throws Exception
     * @author: 憧憬
     */
    public function create(array $param)
    {
        $productBasicModel = self::$model->productBasicModel;
        $relUserProductModel = self::$model->relUserProductModel;
        $productInfoModel = self::$model->productInfoModel;

        // 构建产品基本信息数据
        $basicData = [
            'guid' => Common::getGuid(),
            'title' => $param['title'],
            'thumb' => $param['thumb'],
            'thumb_desc' => $param['thumb_desc'],
        ];

        // 产品详情
        $infoData = [
            'guid' => $basicData['guid'],
            'img' => $param['img'],
            'desc' => $param['desc']
        ];

        // 用户产品关联
        $relUserProductData = [
            'user_guid' => $param['guid'],
            'product_guid' => $basicData['guid']
        ];

        DB::beginTransaction();
        try{
            // 创建产品基本信息
            $productBasicModel->create($basicData);

            // 创建产品信息
            $productInfoModel->create($infoData);

            // 写入产品用户关联表
            $relUserProductModel->create($relUserProductData);

        }catch (\Exception $e) {
            app('log')->debug('添加产品失败'. $e);
            DB::rollBack();
            return [
                'code' => 520,
                'result' => [
                    'info' => '添加产品失败'
                ]
            ];
        }

        DB::commit();

        return [
            'code' => 200,
            'result' => [
                'info' => '添加产品成功',
            ]
        ];
    }


    /**
     * 获取产品详情
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function detail(array $param)
    {
        $productBasicModel = self::$model->productBasicModel;
        $productInfoModel = self::$model->productInfoModel;

        $product = $productBasicModel->where('guid', $param['product_guid'])->first();

        // 验证是否为空
        if (is_null($product)) {
            return [
                'code' => 520,
                'result' => [
                    'info' => '记录不存在',
                ]
            ];
        }

        $product->detail = $productInfoModel->where('guid', $param['product_guid'])->first();

        ProductDetailResource::withoutWrapping();
        $product = new ProductDetailResource($product);

        return [
            'code' => 200,
            'result' => [
                'detail' => $product,
            ]
        ];
    }

    /**
     * 获取产品列表
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function list(array $param)
    {

        $page = $param['page'] ?? 1;
        $limit = $param['limit'] ?? 10;

        $productBasicModel = self::$model->productBasicModel;

        $productBasicWhere = $productBasicModel->where([]);


        if (isset($param['title']) && !empty($param['title'])) {
            $productBasicWhere->where('title', 'like', '%'. $param['title'] .'%');
        }

        if (isset($param['desc']) && !empty($param['desc'])) {
            $productBasicWhere->whereHas('productInfo', function ($query) use ($param) {
                $query->where('desc', 'like', '%'. $param['desc'] .'%');
            });
        }

        if (isset($param['styleTag']) && count($param['styleTag']) > 0) {
            $productBasicWhere->whereHas('productInfo', function ($query) use ($param) {
                $query->whereRaw("style_tag_ids::jsonb @> '".json_encode($param['styleTag'])."'::jsonb");
            });
        }

        $count = $productBasicWhere->count();

        $list = $productBasicWhere->orderBy('id')->forPage($page, $limit)->get();

        return [
            'code' => 200,
            'result' => [
                'list' => $list,
                'sum' => $count
            ]
        ];
    }


    /**
     * 修改产品资料
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function edit(array $param)
    {
        $productBasicModel = self::$model->productBasicModel;
        $productInfoModel = self::$model->productInfoModel;

        $basic = $productBasicModel->where('guid', $param['product_guid'])->first();
        $productInfo = $productInfoModel->where('guid', $param['product_guid'])->first();


        if (empty($basic) || empty($productInfo)) {
            return [
                'code' => 520,
                'result' => [
                    'info' => '记录不存在',
                ]
            ];
        }

        DB::beginTransaction();
        try{
            $updateBasicRes = $this->updateFunc($basic, $param)->save();
            $updateInfoRes = $this->updateFunc($productInfo, $param)->save();
            if (!$updateBasicRes || !$updateInfoRes) throw new Exception('修改失败');
        }catch (Exception $e) {
            app('log')->debug('修改失败'. $e);
            DB::rollBack();
            return [
                'code' => 520,
                'result' => [
                    'info' => '修改失败',
                ]
            ];
        }

        DB::commit();

        return [
            'code' => 200,
            'result' => [
                'info' => '修改成功',
            ]
        ];
    }

    /**
     * 删除产品
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function delete(array $param)
    {
        $productBasicModel = self::$model->productBasicModel;
        $relUserProductModel = self::$model->relUserProductModel;
        $productInfoModel = self::$model->productInfoModel;

        DB::beginTransaction();
        try{
            $basicRes = $productBasicModel->where('guid', $param['product_guid'])->delete();
            $infoRes = $relUserProductModel->where('product_guid', $param['product_guid'])->where('user_guid', $param['guid'])->delete();
            $relUserRes = $productInfoModel->where('guid', $param['product_guid'])->delete();

            if (!$basicRes || !$infoRes || !$relUserRes) throw new Exception('删除失败');

        }catch (Exception $e) {
            DB::rollBack();
            app('log')->debug('删除失败'. $e);
            return [
                'code' => 520,
                'result' => [
                    'info' => '删除失败'
                ]
            ];
        }

        DB::commit();

        return [
            'code' => 200,
            'result' => [
                'info' => '删除成功',
            ]
        ];
    }


}