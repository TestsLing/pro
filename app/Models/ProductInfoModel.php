<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 09:56
 */

namespace App\Models;


use App\Http\Controllers\Traits\ModelExtendTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInfoModel extends Model
{
    use SoftDeletes, ModelExtendTrait;

    protected $table = 'data_product_info';

    public $fillable = [
        'id',
        'guid',
        'desc',
        'img',
        'style_tag_ids'
    ];

    public $timestamps = true;

    protected $casts = ['img' => 'array'];
}