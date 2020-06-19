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
            $table->double('ingreso');
            $table->double('egreso');
            $table->double('saldo');
            $table->string('recibo');
            $table->string('cuenta');
            $table->timestamps();

            $table->index('gestion');
            $table->index('cuenta');
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
