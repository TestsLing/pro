<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 10:29
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductStyleTagModel extends Model
{
    protected $table = 'data_product_style_tag';

    protected $fillable = [
        'id',
        'title'
    ];

    public $timestamps = true;

    /**
     * 查询已启用标签
     * @param $query
     * @return mixed
     * @author: 憧憬
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}