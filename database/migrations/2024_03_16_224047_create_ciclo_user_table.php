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
        Schema::create('ciclo_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ciclo_id')->nullable();
            $table->foreign( 'ciclo_id' )->references( 'id' )->on( 'ciclos' )->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete('cascade');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_user');
    }
};
