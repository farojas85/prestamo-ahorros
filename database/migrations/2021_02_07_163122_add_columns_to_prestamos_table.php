<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropColumn(['incluye_feriados','incluye_sabdom']);
            $table->foreignId('forma_pago_id')->constrained('forma_pagos')
                ->default(1)->after('dias_morosos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign('prestamos_forma_pago_id_foreign');
            $table->dropColumn(['forma_pago']);
            $table->unsignedTinyInteger('incluye_feriados')->default(1)->after('dias_morosos');
            $table->unsignedTinyInteger('incluye_sabdom')->default(1)->after('incluye_feriados');
        });
    }
}
