<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewdenunciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
             $table->increments('idd');
            $table->string('titulo');
            $table->string('direccion');
            $table->float('lat');
            $table->float('lng');
            $table->string('ubicacion');
            $table->string('descripcion');
            $table->string('imagen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('denuncias');
    }
}
