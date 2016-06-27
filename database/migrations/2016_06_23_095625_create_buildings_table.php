<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('time');
            $table->integer('wood');
            $table->string('type');
            $table->integer('level');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('building_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('building_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamp('finished_at')->useCurrent();
            $table->boolean('built')->default(0);
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('SET NULL');
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
        Schema::drop('building_user');
        Schema::drop('buildings');
    }
}
