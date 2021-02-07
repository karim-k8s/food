<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('compet_id');
            //$table->primary('compet_id');
            $table->unsignedInteger('hostteam_id');
            $table->foreign('hostteam_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->unsignedInteger('terrain_id');
            $table->foreign('terrain_id')
                  ->references('terrain_id')->on('terrains')
                  ->onDelete('cascade');
            $table->unsignedInteger('res_id');
            $table->foreign('res_id')
                  ->references('res_id')->on('reservations')
                  ->onDelete('cascade');
            $table->text('compet_teams');
            $table->unsignedInteger('winteam_id');
            $table->foreign('winteam_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->string('status');
            $table->text('compet_log');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
