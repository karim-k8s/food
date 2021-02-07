<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terrains', function (Blueprint $table) {
            $table->increments('terrain_id');
            //$table->primary('terrain_id');
            $table->unsignedInteger('quartier_id');
            $table->foreign('quartier_id')
                  ->references('quartier_id')->on('quartiers')
                  ->onDelete('cascade');
            $table->string('terrain_name_fr')->charset('utf8');
            $table->string('terrain_name_ar')->charset('utf8');
            $table->string('terrain_email');
            $table->string('terrain_phone');
            $table->point('terrain_position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terrains');
    }
}
