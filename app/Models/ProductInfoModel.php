<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 09:56
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInfoModel extends Model
{
    use SoftDeletes;

    protected $table = 'data_product_info';

    public $fillable = [
        'id',
        'guid',
        'desc',
        'img',
    ];

    public $timestamps = true;

    protected $casts = ['img' => 'array'];
}