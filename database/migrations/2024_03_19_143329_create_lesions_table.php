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
        Schema::create('lesions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            // $table->string('url')->nullable();
            // $table->string('iframe')->nullable();
            $table->unsignedBigInteger('contenido_curso_id')->nullable();
            $table->foreign( 'contenido_curso_id' )->references( 'id' )->on( 'contenido_cursos' )->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesions');
    }
};
