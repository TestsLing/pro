<?php
/**
 * Created by PhpStorm.
 * User: cto
 * Date: 2019/3/13
 * Time: 17:12
 */

namespace App\Http\Controllers\Traits;

trait UpdateTrait
{

    /*
    |--------------------------------------------------------------------------
    | $paramMapping Example
    |--------------------------------------------------------------------------
    |
    |    [
    |       param_key => db_field
    |    ]
    |
    */

    /**
     * @param $model object 模型
     * @param $param array 需要修改的参数 业务参数
     * @param string $type 默认是简单修改 简单就是param的键与数据库字段一致
     * @param array $paramMapping 复杂修改 需要做一个映射  数组key是param传入的 val是数据对应字段
     * @return mixed
     * @author: 憧憬
     */
    public function updateFunc($model, $param, $type = 'EASY', $paramMapping = [])
    {
        unset($param['guid']);

        switch ($type) {
            case 'EASY':
                // 简单修改
                foreach ($param as $k=>$v) {
                    if(in_array($k, $model->getFillable())){
                        $model->{$k} = $v;
                    }
                }
                break;

            case 'MAPPING':
                // 设置对照字段修改 $k 指传递过来的键   $v是数据库对应字段
                foreach ($paramMapping as $k=>$v) {
                    if (isset($param[$k]) && in_array($v, $model->getFillable())) {
                        $model->{$v} = $param[$k];
                    }
                }
                break;

            default:

                break;
        }
        return $model;
    }


}