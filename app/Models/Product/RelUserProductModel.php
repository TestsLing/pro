<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-14
 * Time: 12:07
 */

namespace App\Models\Product;


use Illuminate\Database\Eloquent\Model;

class RelUserProductModel extends Model
{
    protected $table = 'rel_user_product';

    protected $guarded = [];

    public $timestamps = true;

}