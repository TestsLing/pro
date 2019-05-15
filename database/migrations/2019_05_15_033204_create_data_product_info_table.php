<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataProductInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_product_info', function (Blueprint $table) {
            $table->increments('id');
            $table->char('guid', 32);
            $table->text('desc')->nullable(true);
            $table->json('img')->nullable(true);
            $table->jsonb('style_tag_ids')->default('[]');
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
        Schema::dropIfExists('data_product_info');
    }
}
