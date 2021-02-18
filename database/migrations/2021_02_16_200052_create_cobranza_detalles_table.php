<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobranzaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobranza_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cobranza_id')->constrained('cobranzas');
            $table->foreignId('cuota_id')->constrained('cuotas');
            $table->decimal('monto',18,2);
            $table->integer('cantidad');
            $table->decimal('importe',18,2);
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
        Schema::dropIfExists('cobranza_detalles');
    }
}
