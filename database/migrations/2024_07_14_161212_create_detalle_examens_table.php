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
        Schema::create('detalle_examens', function (Blueprint $table) {
            $table->id();
            $table->double('puntaje');
            $table->integer('preguntasCorrectas');
            $table->integer('preguntasEnBlanco');
            $table->integer('preguntasIncorrectas');
            $table->double('tiempoConsumido');
            $table->unsignedBigInteger('user_examen_id');
            $table->foreign( 'user_examen_id' )->references( 'id' )->on( 'user_examens' )->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_examens');
    }
};
