<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')
                    ->onUpdate('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')
                    ->onUpdate('cascade');
            $table->datetime('fecha_prestamo');
            $table->foreignId('moneda_id')->nullable()->constrained('monedas')
                    ->onUpdate('cascade');
            $table->decimal('tipo_cambio',18,2)->default(0.00);
            $table->foreignId('tasa_interes_id')->nullable()->constrained('tasa_interes')
                    ->onUpdate('cascade');
            $table->decimal('monto',18,2);
            $table->decimal('interes',18,2);
            $table->foreignId('tipo_cuota_id')->nullable()->constrained('tipo_cuotas')
                    ->onUpdate('cascade');
            $table->unsignedInteger('numero_cuotas');
            $table->unsignedInteger('dias_morosos');
            $table->unsignedTinyInteger('incluye_feriados')->default(1);
            $table->unsignedTinyInteger('incluye_sabdom')->default(1);
            $table->foreignId('estado_operacion_id')->nullable()->constrained('estado_operacions')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists('prestamos');
    }
}
