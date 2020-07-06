<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('miembro_id');
            $table->unsignedBigInteger('diario_id')->nullable();
            $table->smallInteger('mes')->nullable();
            $table->smallInteger('gestion')->nullable();
            $table->double('monto')->default(0);
            $table->timestamps();

            $table->foreign('miembro_id')->references('id')->on('miembros');
            $table->foreign('diario_id')->references('id')->on('diarios');
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
