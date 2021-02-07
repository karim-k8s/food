<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('match_id');
            //$table->primary('match_id');
            $table->unsignedInteger('hostteam_id');
            $table->foreign('hostteam_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->unsignedInteger('guestteam_id');
            /*$table->foreign('guestteam_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');*/
            $table->unsignedInteger('res_id');
            $table->foreign('res_id')
                  ->references('res_id')->on('reservations')
                  ->onDelete('cascade');
            $table->unsignedInteger('terrain_id');
            $table->foreign('terrain_id')
                  ->references('terrain_id')->on('terrains')
                  ->onDelete('cascade');
            $table->string('match_result');
            $table->dateTime('match_start');
            $table->dateTime('match_end');
            $table->integer('accept')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
