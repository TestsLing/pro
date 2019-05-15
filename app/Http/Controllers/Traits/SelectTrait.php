<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 12:47
 */

namespace App\Http\Controllers\Traits;


trait SelectTrait
{

    /**
     * jsonb包含查询
     * @param $model object 模型实例
     * @param $column string 需要查询的列
     * @param $value array 需要查询包含的数组 传入空数组即查询所有
     * @return mixed
     * @author: 憧憬
     */
    public function whereColumnContains($model, string $column, array $value)
    {
         $model->whereRaw("$column::jsonb @> '".json_encode($value)."'::jsonb");
         return $model;
    }


}