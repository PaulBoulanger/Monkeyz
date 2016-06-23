<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('time');
            $table->integer('bananas');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('technology_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('technology_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('launched_at');
            $table->timestamp('finished_at');
            $table->boolean('built')->default(0);
            $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('technology_user');
        Schema::drop('technologies');
    }
}
