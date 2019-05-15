<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 10:42
 */

namespace App\Services;


class TagService
{
    protected static $model;

    public function __construct()
    {
        self::$model = app('model');
    }

    /**
     * 获取标签列表
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function list(array $param)
    {
        $productStyleTagModel = self::$model->productStyleTagModel;

        $list = $productStyleTagModel->active()->get();

        return [
            'code' => 200,
            'result' => [
                'list' => $list
            ]
        ];
    }


    /**
     * 添加标签
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function create(array $param)
    {
        $productStyleTagModel = self::$model->productStyleTagModel;

        try{
            $productStyleTagModel->create([
                'title' => $param['title']
            ]);
        }catch (\Exception $e) {
            app('log')->debug('创建标签失败 '. $e);
            return [
                'code' => 520,
                'result' => [
                    'info' => '创建失败'
                ]
            ];
        }


        return [
            'code' => 200,
            'result' => [
                'info' => '创建成功'
            ]
        ];
    }


    /**
     * 获取所有标签
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function all(array $param)
    {
        $tagModel = self::$model->tagModel;

        $list = $tagModel->get();


        return [
            'code' => 200,
            'result' => [
                'list' => $list
            ]
        ];
    }


}