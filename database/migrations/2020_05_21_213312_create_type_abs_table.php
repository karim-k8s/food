<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeAbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_abs', function (Blueprint $table) {
            $table->increments('typeab_id');
            //$table->primary('typeab_id');
            $table->string('typeab_name');
            $table->integer('typeab_duration');
            $table->float('typeab_price',8,2);
            $table->integer('typerab_hoursamount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_abs');
    }
}
