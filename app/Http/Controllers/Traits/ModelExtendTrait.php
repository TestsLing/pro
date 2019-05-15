<?php

/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-19
 * Time: 14:11
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\DB;



trait ModelExtendTrait {

    /**
     * 删除指定数组元素 pgsql
     * @param $key string 需要移除元素的键
     * @param $val string 需要移除元素的值
     * @param $id integer 需要更新的id
     * @return int
     * @author: 憧憬
     */
    public function removeIdsForPgsql($key, $val, $id)
    {
        // 如果元素只剩最后一个  进行移除  那么写入一个null值

        $updateSql = "update {$this->table} set {$key} = array_remove({$key}, ?) where id = ?";

        $selectSql = "select array_length({$key}, ?) AS length from {$this->table} where id = ?";

        $updateRes = DB::update($updateSql, [$val, $id]);

        if ($updateRes < 1) {
            return 0;
        }else{
            $selectRes = DB::select($selectSql,[1, $id]);

            if ($selectRes[0]->length === null) {
                $column = $this->find($id);
                $column->{$key} = null;
                $saveRes = $column->save();

                if (!$saveRes) {
                    return 0;
                }
            }

            return $updateRes;
        }

    }


    /**
     * @param $key string 需要更新的键
     * @param $val string 需要插入的值
     * @param $id integer 需要更新的id
     * @return int
     * @author: 憧憬
     */
    public function appendIdsForPgsql($key, $val, $id)
    {
        $sql = "update {$this->table} set {$key} = array_append({$key}, ?) where id = ?";

        return DB::update($sql, [$val, $id]);
    }


}