<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->double('monto');
            $table->string('fecha_pago');
            $table->string('descripcion');
            $table->unsignedBigInteger('ciclo_id')->nullable();
            $table->foreign( 'ciclo_id' )->references( 'id' )->on('ciclos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
