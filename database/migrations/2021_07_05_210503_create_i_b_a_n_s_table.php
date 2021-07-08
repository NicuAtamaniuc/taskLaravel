<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIBANSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_b_a_n_s', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anul');
            $table->string('kd_eco',6);
            $table->string('kd_local',4);
            $table->string('kd_trez',2);
            $table->string('iban',50);
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
        Schema::dropIfExists('i_b_a_n_s');
    }
}
