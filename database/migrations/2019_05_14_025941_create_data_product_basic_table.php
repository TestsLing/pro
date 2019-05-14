<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataProductBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_product_basic', function (Blueprint $table) {
            $table->increments('id');
            $table->char('guid', 32);
            $table->text('thumb')->nullable(true);
            $table->text('thumb_desc')->nullable(true);
            $table->text('title');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_product_basic');
    }
}
