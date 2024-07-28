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
        Schema::create('resultado_examens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_examen_id');
            $table->foreign( 'user_examen_id' )->references( 'id' )->on( 'user_examens' )->onDelete('cascade');
            $table->unsignedBigInteger('question_id');
            $table->foreign( 'question_id' )->references( 'id' )->on( 'questions' );
            $table->unsignedBigInteger('option_id')->nullable();;
            $table->foreign( 'option_id' )->references( 'id' )->on( 'options' );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_examens');
    }
};
