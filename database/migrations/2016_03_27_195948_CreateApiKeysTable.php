<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id');
            $table->string('description');
            $table->string('api_key');
            $table->timestamps();
            $table->index('user_id');
            $table->index('api_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('api_keys');
    }
}
