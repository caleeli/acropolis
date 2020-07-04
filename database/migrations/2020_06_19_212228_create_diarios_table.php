<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('gestion', 4);
            $table->date('fecha');
            $table->string('detalle');
            $table->double('ingreso')->default(0);
            $table->double('egreso')->default(0);
            $table->double('saldo');
            $table->string('recibo')->nullable();
            $table->string('cuenta');
            $table->string('libreta');
            $table->bigInteger('miembro_id')->nullable();
            $table->timestamps();

            $table->index('gestion');
            $table->index('cuenta');
            $table->foreign('miembro_id')->references('id')->on('miembros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diarios');
    }
}
