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
            $table->string('type');
            $table->integer('level');
            $table->integer('time');
            $table->integer('bananas');
            $table->integer('endurance');
            $table->integer('strength');
            $table->integer('agility');
            $table->boolean('upgrade');
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
            $table->timestamp('finished_at');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::create('unit_names', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->enum('lang', ['fr', 'en'])->default('fr');
            $table->string('name');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::create('building_unit', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedInteger('building_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('SET NULL');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('SET NULL');
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
        Schema::drop('building_unit');
        Schema::drop('unit_names');
        Schema::drop('recruit_user');
        Schema::drop('unit_user');
        Schema::drop('units');
    }
}
