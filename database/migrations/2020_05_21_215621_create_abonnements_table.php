<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonnementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnements', function (Blueprint $table) {
            $table->increments('abn_id');
            //$table->primary('abn_id');
            $table->unsignedInteger('typeab_id');
            $table->foreign('typeab_id')
                  ->references('typeab_id')->on('type_abs')
                  ->onDelete('cascade');
            $table->unsignedInteger('team_id');
            $table->foreign('team_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->date('abn_start');
            $table->date('abn_end');
            $table->integer('abn_remaininghours');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abonnements');
    }
}
