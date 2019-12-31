<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aportes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('miembro_id');
            $table->smallInteger('mes');
            $table->smallInteger('gestion');
            $table->date('fecha_pago');
            $table->double('monto');
            $table->string('medio');
            $table->string('recibo');
            $table->string('imagen');
            $table->string('verificado_por')->nullable();

            $table->foreign('miembro_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aportes');
    }
}
