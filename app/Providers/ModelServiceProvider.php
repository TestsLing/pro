<?php
/**
 * Created by 憧憬.
 * User: longshilin
 * Date: 2019-04-29
 * Time: 11:10
 */

namespace App\Providers;


use \Illuminate\Support\ServiceProvider;
use App\Models\Model;

class ModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('model',Model::class);
    }

    public function register()
    {

    }

}