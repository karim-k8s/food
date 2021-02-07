<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('res_id');
            //$table->primary('res_id');
            $table->unsignedInteger('typeres_id');
            $table->foreign('typeres_id')
                  ->references('typeres_id')->on('type_res')
                  ->onDelete('cascade');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->unsignedInteger('abn_id');
            $table->foreign('abn_id')
                  ->references('abn_id')->on('abonnements')
                  ->onDelete('cascade');
            $table->unsignedInteger('terrain_id');
            $table->foreign('terrain_id')
                  ->references('terrain_id')->on('terrains')
                  ->onDelete('cascade');
            $table->integer('res_duration');
            $table->dateTime('res_start');
            $table->dateTime('res_end');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
