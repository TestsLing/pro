<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 12:03
 */

namespace App\Models\Letter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterModel extends Model
{
    use SoftDeletes;

    protected $table = 'data_private_letter';

    public $guarded = [];

    public $timestamps = true;


    /**
     * 关联留言内容
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author: 憧憬
     */
    public function letterContent()
    {
        return $this->hasOne(LetterContentModel::class, 'id', 'content_id');
    }
}