<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 09:56
 */

namespace App\Models\Product;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBasicModel extends Model
{

    use SoftDeletes;

    protected $table = 'data_product_basic';

    public $fillable = [
        'id',
        'guid',
        'thumb',
        'thumb_desc',
        'title'
        ];

    public $timestamps = true;


    /**
     * 关联产品详情
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author: 憧憬
     */
    public function productInfo()
    {
        return $this->hasOne(ProductInfoModel::class, 'guid', 'guid');
    }

}