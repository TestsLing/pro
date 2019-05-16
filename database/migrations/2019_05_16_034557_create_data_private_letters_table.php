<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPrivateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_private_letters', function (Blueprint $table) {
            $table->increments('id');
            $table->char('sender_guid', 32);
            $table->char('receiver_guid', 32);
            $table->integer('content_id');
            $table->smallInteger('is_read')->default(0);
            $table->smallInteger('type')->default(0);
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
        Schema::dropIfExists('data_private_letters');
    }
}
