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
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('nombre')->nullable();
            $table->string('documento')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('semana_id')->nullable();
            $table->foreign( 'semana_id' )->references( 'id' )->on('semanas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};
