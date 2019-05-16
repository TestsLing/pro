<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 10:42
 */

namespace App\Services\Tag;


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
     * 修改标签
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function edit(array $param)
    {
        $productStyleTagModel = self::$model->productStyleTagModel;

        try{
            $tag = $productStyleTagModel->find($param['id']);

            if (empty($tag)) throw new \Exception('未找到标签');

            $tag->title = $param['title'];

            $res = $tag->save();

            if (!$res) throw new \Exception('修改标签失败');

        }catch (\Exception $e) {
            app('log')->debug('修改标签失败 '. $e);
            return [
                'code' => 520,
                'result' => [
                    'info' => '修改标签失败'
                ]
            ];
        }

        return [
            'code' => 200,
            'result' => [
                'info' => '修改标签成功'
            ]
        ];
    }

    /**
     * 删除标签
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function delete(array $param)
    {
        $productStyleTagModel = self::$model->productStyleTagModel;

        try{
            $res = $productStyleTagModel->find($param['id'])->delete();

            if (!$res) throw new \Exception('删除标签失败');

        }catch (\Exception $e) {
            app('log')->debug('删除标签失败 '. $e);
            return [
                'code' => 520,
                'result' => [
                    'info' => '删除标签失败'
                ]
            ];
        }


        return [
            'code' => 200,
            'result' => [
                'info' => '删除标签成功'
            ]
        ];
    }


    /**
     * 禁用标签
     * @param array $param
     * @return array
     * @author: 憧憬
     */
    public function prohibit(array $param)
    {
        $productStyleTagModel = self::$model->productStyleTagModel;

        try{
            $tag = $productStyleTagModel->find($param['id']);

            if (empty($tag)) throw new \Exception('未找到标签');

            $tag->status = 9;

            $res = $tag->save();

            if (!$res) throw new \Exception('禁用标签失败');

        }catch (\Exception $e) {
            app('log')->debug('禁用标签失败 '. $e);
            return [
                'code' => 520,
                'result' => [
                    'info' => '禁用标签失败'
                ]
            ];
        }

        return [
            'code' => 200,
            'result' => [
                'info' => '禁用成功'
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

        if (isset($param['tag'])) {
            $list = $tagModel->whereIn('id', $param['tag'])->get(['id','title']);
        }else{
            $list = $tagModel->get();
        }

        return [
            'code' => 200,
            'result' => [
                'list' => $list
            ]
        ];
    }


}