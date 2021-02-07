<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('teams', function (Blueprint $table) {
            $table->increments('team_id');
            //$table->primary('team_id');
            $table->string('team_name')->charset('utf8');
            $table->string('team_email')->unique();
            $table->string('phone');
            $table->string('team_type');
            $table->unsignedInteger('quartier_id');
            $table->foreign('quartier_id')
                  ->references('quartier_id')->on('quartiers')
                  ->onDelete('cascade');
            $table->string('team_pwd', 64)->charset('utf8');
            $table->string('team_pwdhash', 64);
            $table->string('team_status')->default('non abos');
            $table->string('logo')->default('nologo.png');
            $table->date('team_joined')->default(now());
            $table->integer('team_stat_win')->default(0);
            $table->integer('team_stat_lose')->default(0);
            $table->integer('team_stat_draw')->default(0);
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
