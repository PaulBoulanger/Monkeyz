<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('time');
            $table->integer('bananas');
            $table->integer('endurance');
            $table->integer('strength');
            $table->integer('agility');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('unit_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('units');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::create('recruit_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('units');
            $table->timestamp('launched_at');
            $table->timestamp('finished_at');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
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
        Schema::drop('recruit_user');
        Schema::drop('unit_user');
        Schema::drop('units');
    }
}