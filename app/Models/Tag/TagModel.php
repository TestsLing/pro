<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-15
 * Time: 10:30
 */

namespace App\Models\Tag;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    protected $table = 'data_tag';

    protected $guarded = [];

    public $timestamps = true;
}