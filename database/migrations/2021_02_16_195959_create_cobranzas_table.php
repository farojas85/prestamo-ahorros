<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobranzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranzas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('fecha');
            $table->foreignId('entidad_financiera_id')->constrained('entidad_financieras');
            $table->foreignId('medio_pago_id')->constrained('medio_pagos');
            $table->date('fecha_deposito')->nullable();
            $table->foreignId('serie_id')->nullable()->constrained('series');
            $table->unsignedBigInteger('numero')->nullable();
            $table->string('numero_operacion')->nullable();
            $table->decimal('total',18,2);
            $table->foreignId('estado_operacion_id')->constrained('estado_operacions');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobranzas');
    }
}
