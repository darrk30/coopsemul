<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->string('curso', 100);
            $table->string('rutaArchivo', 255);
            $table->string('codigo', 45);
            $table->string('resolucion', 45);
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('users_id_promotor');
            $table->unsignedBigInteger('users_id_trabajador');
            $table->unsignedBigInteger('empresas_id');
            $table->unsignedBigInteger('tipo_pago_id');
            $table->unsignedBigInteger('tipo_inscripcion_id');
            $table->unsignedBigInteger('especialidad_id');
            $table->timestamps();

            // Relaciones
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('users_id_promotor')->references('id')->on('users');
            $table->foreign('users_id_trabajador')->references('id')->on('users');
            $table->foreign('empresas_id')->references('id')->on('empresas');
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pagos');
            $table->foreign('tipo_inscripcion_id')->references('id')->on('tipo_inscripcions');
            $table->foreign('especialidad_id')->references('id')->on('especialidads');           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
