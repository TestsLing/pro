<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-05-16
 * Time: 12:04
 */

namespace App\Models\Letter;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterContentModel extends Model
{
    use SoftDeletes;

    protected $table = 'data_private_letter_content';

    public $guarded = [];

    public $timestamps = true;
}