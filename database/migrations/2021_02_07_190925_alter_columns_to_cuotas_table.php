<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsToCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuotas', function (Blueprint $table) {
            $table->dropColumn(['cuota_nombre']);
            $table->unsignedTinyInteger('numero_cuota')->after('prestamo_id');
            $table->renameColumn('monto','monto_cuota');
            $table->decimal('saldo',18,2)->after('monto');
            $table->foreignId('estado_operacion_id')->constrained('estado_operacions')->after('saldo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuotas', function (Blueprint $table) {
            $table->string('cuota_nombre');
            $table->renameColumn('monto_cuota','monto');
            $table->dropForeign('cuotas_estado_operacion_id_foreign');
            $table->dropColumn(['numero_cuota','estado_operacion_id']);
        });
    }
}
